<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AvisosYTableroImport;
use Maatwebsite\Excel\Facades\Excel;
//use App\Models\Avisosytablero;
use App\Models\DeclaracionAnul;
class AvisosYTableroController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Importar el archivo
            Excel::import(new AvisosYTableroImport, $request->file('file'));
    
            return response()->json(['message' => '1']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al importar el archivo: ' . $e->getMessage()], 500);
        }
       
    }

    public function allavisosytablero(Request $request)
    {

            $search = $request->input('search');
            $query = DeclaracionAnul::query();
           
            if ($search) {
                $query->where('razon_social', 'like', "%$search%")
                    ->orWhere('nit_contribuyente', 'like', "%$search%");
            }

            $users = $query->paginate($request->input('per_page', 10));

            return response()->json($users);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getallavisosytableros()
     {
         // Obtener todos los usuarios de la base de datos
         $users = DeclaracionAnul::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($users);
       }

}

