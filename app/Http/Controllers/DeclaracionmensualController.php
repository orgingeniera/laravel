<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DeclaracionMensualImport;
use Maatwebsite\Excel\Facades\Excel;
//use App\Models\Avisosytablero;
use App\Models\DeclaracionMensual;
use Illuminate\Support\Facades\Validator;


class DeclaracionmensualController extends Controller
{
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Importar el archivo
            Excel::import(new DeclaracionMensualImport, $request->file('file'));
    
            return response()->json(['message' => '1']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al importar el archivo: ' . $e->getMessage()], 500);
        }
       
    }

    public function alldeclaracionmensual(Request $request)
    {

            $search = $request->input('search');
            $query = DeclaracionMensual::query();
           
            if ($search) {
                $query->where('razon_social', 'like', "%$search%")
                    ->orWhere('nit_contribuyente', 'like', "%$search%");
            }
            // Ordenar por total_ingresos_gravables en orden descendente
            $query->orderBy('total_ingresos_gravables', 'desc');
            $DeclaracionMensuals = $query->paginate($request->input('per_page', 10));

            return response()->json($DeclaracionMensuals);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getallavisosytableros()
     {
         // Obtener todos los usuarios de la base de datos
         $DeclaracionMensuals = DeclaracionMensual::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($DeclaracionMensuals);
       }


       public function getdeclaracionmensualbyId($id)
       {
           // Buscar el usuario por ID
           $DeclaracionMensual = DeclaracionMensual::find($id);
   
           // Verificar si el usuario existe
           if (!$DeclaracionMensual) {
               return response()->json(['message' => 'Declaración no encontrada'], 404);
           }
   
           // Devolver el usuario como respuesta JSON
           return response()->json($DeclaracionMensual);
       }

       public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'n_declaracion' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'vigencia' => 'required|string|max:255',
            'fecha_declaracion' => 'required',
            'nit_contribuyente' => 'required|string',
            'direccion' => 'required|string|max:50',
            'ciudad' => 'required|string|max:50',
        ]);

        // Si la validación falla, retorna los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Inserción del usuario en la base de datos
        $DeclaracionMensual = DeclaracionMensual::create([
            
            'n_declaracion' => $request->n_declaracion,
            'vigencia' => $request->vigencia,
            'periodo' => $request->periodo, // Campo de tipo string
            'fecha_declaracion' => $request->fecha_declaracion,
            'nit_contribuyente' => $request->nit_contribuyente,
            'razon_social' => $request->razon_social,
            'regimen' => $request->regimen,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'correo_electronico' => $request->correo_electronico,
            'total_ingresos_brutos' => $request->total_ingresos_brutos, // Total Ingresos Brutos Ordinarios y Extraordinarios
            'menos_devoluciones_subsidios' => $request->menos_devoluciones_subsidios, // Menos Devoluciones y Subsidios
            'menos_ingresos_fuera_municipio' => $request->menos_ingresos_fuera_municipio, // Menos Ingresos Fuera del Municipio
            'menos_ventas_activos_exportacion' => $request->menos_ventas_activos_exportacion, // Menos Ventas de Activos Fijos y Exportación
            'menos_ingresos_exentos_no_sujetos' => $request->menos_ingresos_exentos_no_sujetos, // Menos Ingresos Exentos y No Sujetas
            'total_ingresos_gravables' => $request->total_ingresos_gravables, // Total Ingresos Gravables Autoretención
            'autoretencion_impuesto_industria_comercio' => $request->autoretencion_impuesto_industria_comercio, // Autoretención de Impuesto de Industria y Comercio
            'mas_autoretenciones_impuestos_avisos_tableros' => $request->mas_autoretenciones_impuestos_avisos_tableros, // Más Autoretenciones de Impuestos de Avisos y Tableros
            'total_autoretencion_mensual' => $request->total_autoretencion_mensual, // Total Autoretención Mensual

        ]);

        // Retorna un mensaje de éxito con los datos del usuario creado
        return response()->json([
            'message' => 'DeclaracionMensual creada exitosamente',
            'DeclaracionMensual' => $DeclaracionMensual
        ], 201);
    }
    
    public function updatdeclaracionmensual(Request $request, $id)
{
    // Validar la solicitud
    $validator = Validator::make($request->all(), [
            'n_declaracion' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'periodo' => 'required|string|max:255',
            'vigencia' => 'required|string|max:255',
            'fecha_declaracion' => 'required',
            'nit_contribuyente' => 'required|string',
            'direccion' => 'required|string|max:50',
            'ciudad' => 'required|string|max:50',
        
    ]);

    // Retornar errores de validación si los hay
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Buscar el usuario por ID
    $DeclaracionMensual = DeclaracionMensual::find($id);
    if (!$DeclaracionMensual) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $DeclaracionMensual->n_declaracion = $request->input('n_declaracion');
    $DeclaracionMensual->vigencia = $request->input('vigencia');
    $DeclaracionMensual->periodo = $request->input('periodo'); // Campo de tipo string
    $DeclaracionMensual->fecha_declaracion = $request->input('fecha_declaracion');
    $DeclaracionMensual->nit_contribuyente = $request->input('nit_contribuyente');
    $DeclaracionMensual->razon_social = $request->input('razon_social');
    $DeclaracionMensual->regimen = $request->input('regimen');
    $DeclaracionMensual->direccion = $request->input('direccion');
    $DeclaracionMensual->ciudad = $request->input('ciudad');
    $DeclaracionMensual->correo_electronico = $request->input('correo_electronico');
    $DeclaracionMensual->total_ingresos_brutos = $request->input('total_ingresos_brutos'); // Total Ingresos Brutos Ordinarios Y Extraordinarios
    $DeclaracionMensual->menos_devoluciones_subsidios = $request->input('menos_devoluciones_subsidios'); // Menos Devoluciones y Subsidios
    $DeclaracionMensual->menos_ingresos_fuera_municipio = $request->input('menos_ingresos_fuera_municipio'); // Menos Ingresos Obtenidos Fuera De Este Municipio
    $DeclaracionMensual->menos_ventas_activos_exportacion = $request->input('menos_ventas_activos_exportacion'); // Menos Ventas De Activos Fijos Y Ventas De Exportacion
    $DeclaracionMensual->menos_ingresos_exentos_no_sujetos = $request->input('menos_ingresos_exentos_no_sujetos'); // Menos Ingresos Por Actividades Exentas Y No Sujetas
    $DeclaracionMensual->total_ingresos_gravables = $request->input('total_ingresos_gravables'); // Total Ingresos Gravables Autoretencion
    $DeclaracionMensual->autoretencion_impuesto_industria_comercio = $request->input('autoretencion_impuesto_industria_comercio'); // Autoretención De Impuesto De Industria Y Comercio
    $DeclaracionMensual->mas_autoretenciones_impuestos_avisos_tableros = $request->input('mas_autoretenciones_impuestos_avisos_tableros'); // Más Autoretenciones De Impuestos De Avisos Y Tableros
    $DeclaracionMensual->total_autoretencion_mensual = $request->input('total_autoretencion_mensual');


    // Guardar los cambios en la base de datos
    $DeclaracionMensual->save();

    // Retornar el usuario actualizado
    return response()->json($DeclaracionMensual, 200);
}
    public function deletedeclaracionmensual($id)
    {
        $declaracionMensual = DeclaracionMensual::find($id);

        if ($declaracionMensual) {
            $declaracionMensual->delete();
            return response()->json(['message' => 'Declaración mensual eliminado con éxito'], 200);
        }

        return response()->json(['message' => 'Declaración mensual no encontrada'], 404);
    }
    public function getallclaracionanual()
    {
        // Obtener todos los usuarios de la base de datos
        $DeclaracionMensual = DeclaracionMensual::all();

        // Devolver los usuarios como respuesta JSON
        return response()->json($DeclaracionMensual);
      }
      public function getAllDeclaracionAnualByNit($nit_contribuyente)
        {
            // Filtrar los registros que coincidan con el NIT del contribuyente
            $declaraciones = DeclaracionMensual::where('nit_contribuyente', $nit_contribuyente)->get();

            // Devolver los registros como respuesta JSON
            return response()->json($declaraciones);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getdeclaracionmensualexportar()
     {
         // Obtener todos los usuarios de la base de datos
         $declaracionMensual = DeclaracionMensual::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($declaracionMensual);
       }
       public function eliminarDeclaracionesMensuales()
       {
         
           // Elimina todos los datos de la tabla `declaracionesanul`
           DeclaracionMensual::query()->delete();
   
           return response()->json(['message' => 'Datos eliminados correctamente'], 200);
       }
}

