<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vitacora;
class IdiomaController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idiomas = Idioma::all();
        return view('admin.idiomas.index', compact('idiomas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_create' => 'required|max:255|unique:idiomas,nombre',
        ]);
        $idioma = new Idioma();
        $idioma->nombre = $request->nombre_create;
        $idioma->save();

        Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Se creó un idioma: ' . $idioma->nombre,
            'hora' => now(),
        ]);

        return redirect()->route('admin.idiomas.index')
            ->with('mensaje', 'El idioma se ha creado correctamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idioma $idioma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idioma $idioma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validación manual para manejo personalizado de errores
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|max:255|unique:idiomas,nombre,' . $id,
        ]);

        // 2. Si la validación falla, redirige con errores e ID del modal
        if ($validate->fails()) {
            return redirect()
                ->back()
                ->withErrors($validate)
                ->withInput()
                ->with('modal_id', $id);
        }

        $idioma = Idioma::find($id);
        $idioma->nombre = $request->nombre;
        $idioma->save();

        Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Se editó un idioma: ' . $idioma->nombre,
            'hora' => now(),
        ]);

        return redirect()->route('admin.idiomas.index')
            ->with('mensaje', 'El idioma se ha actualizado correctamente')
            ->with('icono', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $idioma = Idioma::find($id);
        $nombre = $idioma->nombre;
        $idioma->delete();

        Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Se eliminó un idioma: ' . $nombre,
            'hora' => now(),
        ]);

        return redirect()->route('admin.idiomas.index')
            ->with('mensaje', 'El idioma se ha eliminado correctamente')
            ->with('icono', 'success');
    }
}
