<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }
    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $usuario->id,
            'role' => 'required|exists:roles,name',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Asignar nuevo rol
        $usuario->syncRoles([$request->role]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        if (auth()->user()->id === $usuario->id) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propia cuenta.');
        }
    
        $usuario->delete();
    
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
    

}
