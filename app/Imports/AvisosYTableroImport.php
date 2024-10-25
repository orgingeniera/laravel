<?php

namespace App\Imports;

use App\Models\DeclaracionAnul;
//use App\Models\Avisosytablero;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date; //fechas
use DateTime;

class AvisosYTableroImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        \Log::info('Importando fila:', $row->toArray());
        $fechaDeclaracion = $row['fecha_declaracion'];

        // Verificar si la fecha es un número serial de Excel
        if (is_numeric($fechaDeclaracion)) {
            // Si es un número serial, convertirlo a un objeto DateTime
            $dateTime = Date::excelToDateTimeObject($fechaDeclaracion);
            $fechaDeclaracion = $dateTime->format('Y-m-d'); // Convertir a formato Y-m-d
        } else {
            // Si no es un número, intentar convertirla desde el formato d/m/Y
            $dateTime = DateTime::createFromFormat('d/m/Y', $fechaDeclaracion);
            if ($dateTime) {
                $fechaDeclaracion = $dateTime->format('Y-m-d');
            } else {
                \Log::error("Fecha no válida: $fechaDeclaracion"); // Esto ayudará a depurar
            }
        }
        // Crear un nuevo registro en la base de datos para cada fila
        $DeclaracionAnul = new DeclaracionAnul([
            'n_declaracion'                  => $row['n_declaracion'],
            'vigencia'                       => $row['vigencia'],
            'fecha_declaracion'              => $fechaDeclaracion,
            'nit_contribuyente'              => $row['nit_contribuyente'],
            'razon_social'                   => $row['razon_social'],
            'regimen'                        => $row['regimen'],
            'direccion'                      => $row['direccion'],
            'ciudad'                         => $row['ciudad'],
            'correo_electronico'             => $row['correo_electronico'],
            'total_ingresos_nacionales'      => $row['total_ingresos_nacionales'],
            'menos_ingresos_fuera_municipio' => $row['menos_ingresos_fuera_municipio'],
            'total_ingresos_municipio'       => $row['total_ingresos_municipio'],
            'menos_ingresos_rebajas'         => $row['menos_ingresos_rebajas'],
            'menos_ingresos_exportaciones'   => $row['menos_ingresos_exportaciones'],
            'menos_ingresos_venta_activos'   => $row['menos_ingresos_venta_activos'],
            'menos_ingresos_no_gravados'     => $row['menos_ingresos_no_gravados'],
            'menos_ingresos_exentos'         => $row['menos_ingresos_exentos'],
            'total_ingresos_gravables'       => $row['total_ingresos_gravables'],
            'total_impuesto'                 => $row['total_impuesto'],
            'capacidad_kw'                   => $row['capacidad_kw'],
            'impuesto_ley_56'                => $row['impuesto_ley_56'],
            'total_industria_comercio'       => $row['total_industria_comercio'],
            'impuesto_avisos_tableros'       => $row['impuesto_avisos_tableros'],
            'pago_unidades_adicionales'      => $row['pago_unidades_adicionales'],
            'sobretasa_bomberil'             => $row['sobretasa_bomberil'],
            'sobretasa_seguridad'            => $row['sobretasa_seguridad'],
            'total_impuesto_cargo'           => $row['total_impuesto_cargo']
        ]);
        
    
        $DeclaracionAnul->save(); // Intenta guardar el registro
    
        return $DeclaracionAnul;
    }
}
