<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\ValidPassword;

class PasswordController extends Controller
{
    public function change()
    {
        return view('admin.password.change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', new ValidPassword()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Registrar en vitácora
        \App\Models\Vitacora::create([
            'usuario' => $user->name,
            'accion' => 'Se cambió de contraseña',
            'hora' => now(),
        ]);

        return back()->with('success', 'Contraseña cambiada exitosamente.');
    }
}
