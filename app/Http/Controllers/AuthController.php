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

            $search = $request->input('search');
            $query = User::query();

            if ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            }

            $users = $query->paginate($request->input('per_page', 10));

            return response()->json($users);
        }
        // Método para obtener todos los usuarios sin paginación
        public function getallusers()
        {
       // Obtener todos los usuarios de la base de datos
       $users = User::all();

       // Devolver los usuarios como respuesta JSON
       return response()->json($users);
   }
    
    public function logout(Request $request)
    {
        return response()->json(['message' => 'Cerro sesion']);
    }
}
