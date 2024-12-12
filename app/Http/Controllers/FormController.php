<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    function persetujuan(){
        return view('form.persetujuan');
    }

    function data_diri(){
        return view('form.data_diri');
    }

    function pilih_jadwal(){
        return view('form.pilih_jadwal');
    }

    function ketentuan_submit(){
        return view('form.ketentuan_submit');
    }

    function pembayaran(){
        return view('form.pembayaran');
    }

}
