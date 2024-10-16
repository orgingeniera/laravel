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

        $perPage = $request->input('per_page', 10); // 10 es el valor por defecto
        $users = User::paginate($perPage); // Pagina los usuarios con la cantidad especificada
        return response()->json($users);

    }
    
    public function logout(Request $request)
    {
        return response()->json(['message' => 'Cerro sesion']);
    }
}
