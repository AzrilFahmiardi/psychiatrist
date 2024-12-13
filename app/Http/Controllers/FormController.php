<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Departemen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    function persetujuan()
    {
        return view('form.persetujuan');
    }

    function data_diri()
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();

        $departemen = Departemen::all();
        
        $prodi = ProgramStudi::all();


        return view('form.data_diri', compact('user', 'departemen', 'prodi'));
    }

    function pilih_jadwal()
    {
        return view('form.pilih_jadwal');
    }

    function ketentuan_submit()
    {
        return view('form.ketentuan_submit');
    }

    function pembayaran()
    {
        return view('form.pembayaran');
    }
}
