<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Método para iniciar sesión
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        
        // Intenta autenticarse con las credenciales proporcionadas
        if (!$token = JWTAuth::attempt($validatedData)) {
            // Si las credenciales no son válidas
            return response()->json(['message' => 'error'], 401);
        }

    // Si la autenticación fue exitosa, devuelve el token
    return response()->json(['token' => $token], 200);
    }
    // Método para obtener usuario autenticado
    /*public function me()
    {
        return response()->json(Auth::user());
    }*/
    public function alluser(Request $request)
    {
        return response()->json($request->user());
    }
    public function logout(Request $request)
    {
        return response()->json(['message' => 'Cerro sesion']);
    }
}
