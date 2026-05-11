<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Vitacora;

class EstudianteController extends Controller
{
      public function index()
    {
        $estudiantes = Estudiante::all();
        return view('admin.estudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.estudiantes.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'rol'              => 'required',
            'nombres'          => 'required',
            'apellidos'        => 'required',
            'ci'               => 'required|unique:estudiantes',
            'fecha_nacimiento' => 'required',
            'telefono'         => 'required',
            'genero'           => 'required',
            'email'            => 'required|unique:users',
            'direccion'        => 'required',
            'foto'             => 'required',
        ]);

        $usuario = new User();
        $usuario->name     = $request->apellidos . ' ' . $request->nombres;
        $usuario->email    = $request->email;
        $usuario->password = Hash::make($request->ci . strtoupper(substr($request->nombres, 0, 1)) . strtolower(substr($request->apellidos, 0, 1)));
        $usuario->save();

        $usuario->assignRole($request->rol);

        $estudiante = new Estudiante();
        $estudiante->usuario_id = $usuario->id;

        $estudiante->nombres = $request->nombres;
        $estudiante->apellidos = $request->apellidos;
        $estudiante->ci = $request->ci;
        $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
        $estudiante->direccion = $request->direccion;
        $estudiante->telefono = $request->telefono;
        $estudiante->genero = $request->genero;
        $estudiante->estado = "activo";

        $fotoPath = $request->file('foto');
        $nombreArchivo = time() . '_' . $fotoPath->getClientOriginalName();
        $rutaDestenio = public_path('uploads/fotos/estudiantes');
        $fotoPath->move($rutaDestenio, $nombreArchivo);
        $estudiante->foto = 'uploads/fotos/estudiantes/' . $nombreArchivo;

        $estudiante->save();

        Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Creó estudiante: ' . $estudiante->nombres . ' ' . $estudiante->apellidos,
            'hora' => now(),
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('mensaje', 'El estudiante se ha creado correctamente')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $estudiante = Estudiante::with('usuario')->find($id);
        return  view('admin.estudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $estudiante = Estudiante::with('usuario')->find($id);
        
        $roles = Role::all();

        return view('admin.estudiantes.edit', compact('estudiante', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $estudiante = Estudiante::find($id);
        $usuario = User::find($estudiante->usuario_id);

        $request->validate([
            
            'rol'              => 'required',
            'nombres'          => 'required',
            'apellidos'        => 'required',
            'ci'               => 'required|unique:estudiantes,ci,' . $id,
            'fecha_nacimiento' => 'required',
            'telefono'         => 'required',
            'genero'           => 'required',
            'email'            => 'required|unique:users,email,' . $usuario->id,
            'direccion'        => 'required',
        ]);

        $usuario->name = $request->apellidos . ' ' . $request->nombres;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->ci . strtoupper(substr($request->nombres, 0, 1)) . strtolower(substr($request->apellidos, 0, 1)));
        $usuario->save();

        $usuario->syncRoles($request->rol);
        $estudiante->usuario_id = $usuario->id;
        
        $estudiante->nombres = $request->nombres;
        $estudiante->apellidos = $request->apellidos;
        $estudiante->ci = $request->ci;
        $estudiante->fecha_nacimiento = $request->fecha_nacimiento;
        $estudiante->direccion = $request->direccion;
        $estudiante->telefono = $request->telefono;
        $estudiante->genero = $request->genero;
        $estudiante->estado = "activo";

        if ($request->hasFile('foto')) {
            //Eliminar foto anterior
            if ($estudiante->foto && file_exists(public_path($estudiante->foto))) {
                unlink(public_path($estudiante->foto));
            }
            $fotoPath = $request->file('foto');
            $nombreArchivo = time() . '_' . $fotoPath->getClientOriginalName();
            $rutaDestenio = public_path('uploads/fotos/estudiantes');
            $fotoPath->move($rutaDestenio, $nombreArchivo);
            $estudiante->foto = 'uploads/fotos/estudiantes/' . $nombreArchivo;
        }

        $estudiante->save();//UPDATE

         Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Actualizó estudiante: ' . $estudiante->nombres . ' ' . $estudiante->apellidos,
            'hora' => now(),
        ]);

         return redirect()->route('admin.estudiantes.index')
            ->with('mensaje', 'El estudiante se ha actualizado correctamente')
            ->with('icono', 'success');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $usuario = User::findOrFail($estudiante->usuario_id);

        //Eliminar foto anterior
        if ($estudiante->foto && file_exists(public_path($estudiante->foto))) {
            unlink(public_path($estudiante->foto));
        }

        $usuario->delete();
        $estudiante->delete();

        Vitacora::create([
            'usuario' => auth()->user()->name,
            'accion' => 'Eliminó estudiante: ' . $estudiante->nombres . ' ' . $estudiante->apellidos,
            'hora' => now(),
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('mensaje', 'El estudiante se ha eliminado correctamente')
            ->with('icono', 'success');
    }
}
