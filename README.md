# Sikolov

Sistem layanan konseling Sekolah Vokasi UGM (Laravel 11 + Vite/Tailwind, MySQL 8).

## Run with Docker

Stack di `docker-compose.yml`:

| Service | Image | Isi |
|---------|-------|-----|
| `app` | dibangun dari `Dockerfile` | PHP 8.4 + web server [FrankenPHP](https://frankenphp.dev) (Caddy), asset Vite sudah di-build. Listen HTTP di port 8080 dalam container. |
| `db` | `mysql:8.0` | Database. Data disimpan di volume `db-data`. |

Volume `storage` menyimpan `storage/` Laravel (termasuk upload bukti pembayaran di `storage/app/public`).
Aplikasi ini tidak memakai queue worker maupun scheduler, jadi tidak ada container untuk itu.

Kebutuhan: Docker Engine + Docker Compose v2.

### 1. Konfigurasi

```bash
cp .env.example .env
```

Isi minimal di `.env`:

- `APP_KEY` — kalau migrasi dari server lama, **pakai APP_KEY lama**. Kalau instalasi baru, generate dengan
  `docker compose run --rm --no-deps app php artisan key:generate --show` lalu tempel hasilnya.
- `APP_URL` — URL publik, mis. `https://sikolov.ugm.ac.id`.
- `DB_DATABASE`, `DB_USERNAME` (jangan `root`), `DB_PASSWORD`, `DB_ROOT_PASSWORD`.
- `CLIENT_ID`, `CLIENT_SECRET`, `CALLBACK_REDIRECT` — Google OAuth. Kalau domain berubah, tambahkan
  `CALLBACK_REDIRECT` yang baru (`<APP_URL>/auth/google-callback`) ke *Authorized redirect URIs* di Google Cloud Console.
- `APP_BIND` / `APP_PORT` — alamat & port host yang dibuka (default `127.0.0.1:8013`).
- `TRUSTED_PROXIES` — IP reverse proxy di depan app (default `*`), supaya URL yang di-generate memakai `https`.

`DB_CONNECTION`, `DB_HOST`, dan `DB_PORT` otomatis di-override oleh compose ke container `db`.

### 2. Build & jalankan

```bash
docker compose build
docker compose up -d
docker compose exec app php artisan migrate --force
```

Cek: `curl http://127.0.0.1:8013/up` harus `200`. Symlink `public/storage` sudah dibuat di image
(setara `php artisan storage:link`), jadi tidak perlu dijalankan manual.

Set `RUN_MIGRATIONS=true` di `.env` kalau ingin migrasi otomatis setiap container `app` start.
Setiap start, container juga menjalankan `php artisan optimize` (cache config/route/view), jadi setelah mengubah
`.env` cukup `docker compose up -d` lagi (container dibuat ulang).

### 3. Reverse proxy & HTTPS

Container hanya melayani HTTP. Arahkan nginx/Apache/Traefik server ke `http://127.0.0.1:8013` dan teruskan
header `Host` serta `X-Forwarded-Proto`. Contoh nginx:

```nginx
location / {
    proxy_pass http://127.0.0.1:8013;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    client_max_body_size 12m;
}
```

### 4. Pindah data dari server lama

Di **server lama** (app di `/var/www/html/sikolov`, MySQL 8.0 lokal, database `sikolov`):

```bash
# dump database
sudo mysqldump --single-transaction --no-tablespaces sikolov > sikolov.sql
# file upload (bukti pembayaran)
sudo tar czf sikolov-storage.tar.gz -C /var/www/html/sikolov/storage/app public
# catat APP_KEY, CLIENT_ID, CLIENT_SECRET dari /var/www/html/sikolov/.env
```

Salin `sikolov.sql` dan `sikolov-storage.tar.gz` ke server baru, lalu di folder repo ini:

```bash
docker compose up -d
# import database (sebelum menjalankan migrate)
docker compose exec -T db sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"' < sikolov.sql
# restore file upload
docker compose exec -T app tar xzf - -C storage/app < sikolov-storage.tar.gz
# jalankan migrasi yang mungkin belum ada di dump
docker compose exec app php artisan migrate --force
```

Kalau import dilakukan ke database yang sudah terisi (mis. sudah sempat `migrate`), kosongkan dulu:

```bash
docker compose exec db sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -e "DROP DATABASE \`$MYSQL_DATABASE\`; CREATE DATABASE \`$MYSQL_DATABASE\`"'
```

### 5. Data demo (opsional, jangan di production)

`database/seeders` hanya berisi akun & jadwal demo dengan password lemah, dan butuh Faker (dependency dev):

```bash
docker compose build --build-arg INSTALL_DEV_DEPS=true
docker compose up -d
docker compose exec app php artisan migrate --seed --force
```

### Operasional

```bash
docker compose logs -f app                      # log aplikasi (juga di storage/logs/laravel.log)
docker compose exec app php artisan <command>   # artisan
git pull && docker compose up -d --build        # update ke versi terbaru
# backup database
docker compose exec -T db sh -c 'mysqldump --single-transaction --no-tablespaces -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"' > backup.sql
```

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
