<?php

namespace App\Http\Controllers;

use App\Models\DeclaracionesanulImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeclaracionesanulImageController extends Controller
{
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de ajustar las validaciones según tus necesidades
            'declaracionesanul_id' => 'required|exists:declaracionesanul,id', // Verifica que el id exista en la tabla
        ]);

        // Almacenar la imagen
        $path = $request->file('image')->store('images', 'public'); // Guarda la imagen en el directorio 'storage/app/public/images'

        // Crear la entrada en la base de datos
        $declaracionanulImage = new DeclaracionesanulImage();
        $declaracionanulImage->image_path = $path; // Suponiendo que tienes un campo 'image_path' en tu modelo
        $declaracionanulImage->declaracionesanul_id = $request->declaracionesanul_id; // Relación con la tabla declaracionesanul
        $declaracionanulImage->save();

        return response()->json([
            'message' => 'Imagen subida exitosamente',
            'data' => $declaracionanulImage,
        ], 201);
    }
}
