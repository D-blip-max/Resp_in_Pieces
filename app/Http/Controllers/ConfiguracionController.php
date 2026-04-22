<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configuracion = Configuracion::first(); //guarda los datos del Modelos en la DB
        return view('admin.configuracion.index', compact('configuracion')); //retorna en la vista la var configuracion   
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
            'nombre'             => 'required',
            'descripcion'        => 'required',
            'direccion'          => 'required',
            'telefono'           => 'required',
            'divisa'             => 'required',
            'correo_electronico' => 'required|email',
            'logo'               => 'image|mimes:jpeg,png,jpg,gif', // Soporte para el mono GIF
        ]);

        // 2. BUSCAR si ya existe una configuración previa
        $configuracion = Configuracion::first();

        if ($configuracion) {
            // --- CASO: ACTUALIZAR EXISTENTE ---
            $configuracion->nombre = $request->nombre;
            $configuracion->descripcion = $request->descripcion;
            $configuracion->direccion = $request->direccion;
            $configuracion->telefono = $request->telefono;
            $configuracion->divisa = $request->divisa;
            $configuracion->web = $request->web;
            $configuracion->correo_electronico = $request->correo_electronico;

            if ($request->hasFile('logo')) {
                // Eliminar el logo anterior físicamente si existe para no llenar el server de basura
                /* if ($configuracion->logo) {
          unlink(public_path($configuracion->logo));
        }
        */        // Eliminar logo anterior
                if ($configuracion->logo && file_exists(public_path($configuracion->logo))) {
                    unlink(public_path($configuracion->logo));
                }

                $file = $request->file('logo');
                $nombreArchivo = time() . '_' . $file->getClientOriginalName();
                $rutaDestino = public_path('uploads/logos');

                $file->move($rutaDestino, $nombreArchivo);
                $configuracion->logo = 'uploads/logos/' . $nombreArchivo;
            }

            $configuracion->save();

            return redirect()->route('admin.configuracion.index')
                ->with('mensaje', 'Configuración actualizada correctamente.')
                ->with('icono', 'success');
        } else {
            // --- CASO: CREAR NUEVA ---
            $configuracion = new Configuracion();
            $configuracion->nombre = $request->nombre;
            $configuracion->descripcion = $request->descripcion;
            $configuracion->direccion = $request->direccion;
            $configuracion->telefono = $request->telefono;
            $configuracion->divisa = $request->divisa;
            $configuracion->web = $request->web;
            $configuracion->correo_electronico = $request->correo_electronico;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $nombreArchivo = time() . '_' . $file->getClientOriginalName();
                $rutaDestino = public_path('uploads/logos');

                $file->move($rutaDestino, $nombreArchivo);
                $configuracion->logo = 'uploads/logos/' . $nombreArchivo;
            }

            $configuracion->save();

            return redirect()->route('admin.configuracion.index')
                ->with('mensaje', 'Configuración creada correctamente.')
                ->with('icono', 'success');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Configuracion $configuracion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Configuracion $configuracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Configuracion $configuracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Configuracion $configuracion)
    {
        //
    }
}
