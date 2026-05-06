<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vitacora;

class VitacoraController extends Controller
{
    public function index()
    {
        $vitacoras = Vitacora::orderBy('hora', 'desc')->get();
        return view('admin.vitacora.index', compact('vitacoras'));
    }
}
