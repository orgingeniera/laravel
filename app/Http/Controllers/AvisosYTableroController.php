<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AvisosYTableroImport;
use Maatwebsite\Excel\Facades\Excel;

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
}

