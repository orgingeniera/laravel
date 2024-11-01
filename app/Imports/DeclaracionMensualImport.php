<?php

namespace App\Imports;

use App\Models\Declaracionmensual;
//use App\Models\Avisosytablero;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date; //fechas
use DateTime;

class DeclaracionMensualImport implements OnEachRow, WithHeadingRow
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
        $DeclaracionMensual = new Declaracionmensual([
            'n_declaracion'                                 => $row['n_declaracion'],
            'vigencia'                                      => $row['vigencia'],
            'periodo'                                       => $row['periodo'], // Campo de tipo string
            'fecha_declaracion'                             => $fechaDeclaracion, // Mantenido como está
            'nit_contribuyente'                             => $row['nit_contribuyente'],
            'razon_social'                                  => $row['razon_social'],
            'regimen'                                       => $row['regimen'],
            'direccion'                                     => $row['direccion'],
            'ciudad'                                        => $row['ciudad'],
            'correo_electronico'                            => $row['correo_electronico'],
            'total_ingresos_brutos'                         => $row['total_ingresos_brutos'], // Total Ingresos Brutos Ordinarios Y Extraordinarios
            'menos_devoluciones_subsidios'                  => $row['menos_devoluciones_subsidios'], // Menos Devoluciones y Subsidios
            'menos_ingresos_fuera_municipio'               => $row['menos_ingresos_fuera_municipio'], // Menos Ingresos Obtenidos Fuera De Este Municipio
            'menos_ventas_activos_exportacion'              => $row['menos_ventas_activos_exportacion'], // Menos Ventas De Activos Fijos Y Ventas De Exportacion
            'menos_ingresos_exentos_no_sujetos'            => $row['menos_ingresos_exentos_no_sujetos'], // Menos Ingresos Por Actividades Exentas Y No Sujetas
            'total_ingresos_gravables'                      => $row['total_ingresos_gravables'], // Total Ingresos Gravables Autoretencion
            'autoretencion_impuesto_industria_comercio'    => $row['autoretencion_impuesto_industria_comercio'], // Autoretención De Impuesto De Industria Y Comercio
            'mas_autoretenciones_impuestos_avisos_tableros' => $row['mas_autoretenciones_impuestos_avisos_tableros'], // Más Autoretenciones De Impuestos De Avisos Y Tableros
            'total_autoretencion_mensual'                   => $row['total_autoretencion_mensual'], // Total Autoretención Mensual A Cargo

        ]);
        
    
        $DeclaracionMensual->save(); // Intenta guardar el registro
    
        return $DeclaracionMensual;
    }
}
