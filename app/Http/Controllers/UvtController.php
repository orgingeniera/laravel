<?php

namespace App\Http\Controllers;

use App\Models\Uvt;
use Illuminate\Http\Request;

class UvtController extends Controller
{
    public function index()
    {
        return Uvt::first(); // Devuelve el primer UVT
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'valor' => 'required|numeric',
        ]);

        $uvt = Uvt::findOrFail($id);
        $uvt->valor = $request->input('valor');
        $uvt->save();

        return response()->json($uvt, 200);
    }
}
