<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Método para insertar un nuevo usuario en la tabla 'users'
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Si la validación falla, retorna los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Inserción del usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'estado' => $request->estado,
            'password' => Hash::make($request->password),  // Encriptación de la contraseña
        ]);

        // Retorna un mensaje de éxito con los datos del usuario creado
        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user
        ], 201);
    }
}
