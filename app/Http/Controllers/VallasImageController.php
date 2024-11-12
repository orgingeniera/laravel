<?php

namespace App\Http\Controllers;

use App\Models\VallasImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class VallasImageController extends Controller
{
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Asegúrate de ajustar las validaciones según tus necesidades
            'vallas_id' => 'required|exists:vallas,id', // Verifica que el id exista en la tabla
        ]);

        // Almacenar la imagen
        $path = $request->file('image')->store('images', 'public'); // Guarda la imagen en el directorio 'storage/app/public/images'

        // Crear la entrada en la base de datos
        $vallasImagen = new VallasImagen();
        $vallasImagen->image_path = $path; // Suponiendo que tienes un campo 'image_path' en tu modelo
        $vallasImagen->vallas_id = $request->vallas_id; // Relación con la tabla declaracionesanul
        $vallasImagen->save();

        return response()->json([
            'message' => 'Imagen subida exitosamente',
            'data' => $vallasImagen,
        ], 201);
    }
    public function getImages($vallas_id)
        {
            // Validar que el ID proporcionado exista en la tabla
            $vallasImagens = VallasImagen::where('vallas_id', $vallas_id)->get();

            // Verificar si se encontraron imágenes
            if ($vallasImagens->isEmpty()) {
                return response()->json(['message' => 'No se encontraron imágenes para este publcidad exterior.'], 404);
            }

            // Construye la URL completa para cada imagen
            $vallasImagens->transform(function ($image) {
                $image->image_url = asset('storage/' . $image->image_path); // URL completa
                return $image;
            });

            // Retornar las imágenes
            return response()->json($vallasImagens, 200);
        }
        public function deleteImage($id)
        {
            // Buscar la imagen por ID
            $vallasImagen = VallasImagen::find($id);

            if (!$vallasImagen) {
                return response()->json(['message' => 'Imagen no encontrada'], 404);
            }

            // Eliminar el archivo de la carpeta public/storage/images
            $imagePath = storage_path('app/public/' . $vallasImagen->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath); // Eliminar el archivo
            }

            // Eliminar la entrada en la base de datos
            $vallasImagen->delete();

            return response()->json(['message' => 'Imagen eliminada exitosamente'], 200);
        }


}
