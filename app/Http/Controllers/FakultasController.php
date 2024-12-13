<?php

    namespace App\Http\Controllers;

    use App\Models\Departemen;
    use Illuminate\Http\Request;

    class FakultasController extends Controller
    {
        function getDepartemenData(){
            $departemens = Departemen::all();

            return $departemens;
        }

        // function getprodi()
    }
