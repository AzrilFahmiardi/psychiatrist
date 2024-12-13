<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departemen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{

    function getData(){
        $email = Auth::user()->email ;
        $user = User::where('email', $email)->first();

        $departemen = Departemen::all();
        
        $prodi = ProgramStudi::all();

        return view('components.profile', compact('user', 'departemen', 'prodi'));

    }

    function updateDataPasien(Request $request){
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'semester' => 'required|integer|min:1',
            'usia' => 'required|integer|min:1',
            'departemen' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:15',
            'status_akses_layanan' => 'required|in:psikolog,psikiater,belum pernah',
        ]);

        $email = Auth::user()->email ;
        $pasien = User::where('email', $email)->first();
        $pasien->nama_lengkap = $request->nama_lengkap;
        $pasien->semester = $request->semester;
        $pasien->usia = $request->usia;
        $pasien->departemen = $request->departemen;
        $pasien->program_studi = $request->program_studi;
        $pasien->jenis_kelamin = $request->jenis_kelamin;
        $pasien->no_hp = $request->no_hp;
        $pasien->status_akses_layanan = $request->status_akses_layanan;
        $pasien->role = 'pasien';

        $pasien->update();
        return redirect()->route('home')->with('success', 'Data pasien berhasil diperbarui.');



    }
}
