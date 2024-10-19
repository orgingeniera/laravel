<?php

namespace App\Imports;

use App\Models\Avisosytablero;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class AvisosYTableroImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        \Log::info('Importando fila:', $row->toArray());
        // Crear un nuevo registro en la base de datos para cada fila
        $avisosytablero = new Avisosytablero([
            'nit'       => $row['nit'],
            'telefono'  => $row['telefono'],
            'direccion' => $row['direccion'],
        ]);
    
        $avisosytablero->save(); // Intenta guardar el registro
    
        return $avisosytablero;
    }
}
