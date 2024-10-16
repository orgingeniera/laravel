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
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
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
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
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
    // Método para obtener todos los usuarios sin paginación
    public function getallusers()
    {
        // Obtener todos los usuarios de la base de datos
        $users = User::all();

        // Devolver los usuarios como respuesta JSON
        return response()->json($users);
      }
    public function getuserbyId($id)
    {
        // Buscar el usuario por ID
        $user = User::find($id);

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Devolver el usuario como respuesta JSON
        return response()->json($user);
    }
    public function updateuser(Request $request, $id)
{
    // Validar la solicitud
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8',
        'apellido' => 'required|string|max:255',
        'telefono' => 'required|string|max:15',
        'estado' => 'required|string|max:50',
    ]);

    // Retornar errores de validación si los hay
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Buscar el usuario por ID
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    // Actualizar el usuario
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    // Solo actualizar la contraseña si se proporciona
    if ($request->input('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $user->apellido = $request->input('apellido');
    $user->telefono = $request->input('telefono');
    $user->direccion = $request->input('direccion');
    $user->estado = $request->input('estado');

    // Guardar los cambios en la base de datos
    $user->save();

    // Retornar el usuario actualizado
    return response()->json($user, 200);
}
}
