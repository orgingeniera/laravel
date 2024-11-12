<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AvisosYTableroImport;
use Maatwebsite\Excel\Facades\Excel;
//use App\Models\Avisosytablero;
use App\Models\Valla;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class VallasController extends Controller
{
    public function countVallas()
    {
        // Contar el número de usuarios en la tabla 'users'
        $userCount = Valla::count();

        // Devolver el conteo como respuesta JSON
        return response()->json(['count' => $userCount], 200);
    }
  
    public function registrosCercanosACumplirAnio()
{
    // Obtener la fecha actual
    $fechaActual = Carbon::now();

    // Calcular la fecha hace 10 meses y hasta 2 meses en el futuro
    $fechaLimiteInicio = $fechaActual->copy()->subYear()->subMonths(2); // Hace casi un año (10 meses hacia atrás)
    $fechaLimiteFin = $fechaActual->copy()->addMonths(2); // Hasta 2 meses en el futuro

    // Obtener los registros que cumplan con la condición
    $vallas = Valla::whereBetween('fecha_instalacion', [$fechaLimiteInicio, $fechaLimiteFin])->get();

    // Agregar los meses restantes para cumplir el año a cada registro
    $vallasConMesesRestantes = $vallas->map(function ($valla) use ($fechaActual) {
        // Convertir fecha_instalacion a un objeto Carbon si es un string
        $fechaInstalacion = Carbon::parse($valla->fecha_instalacion);
        
        // Calcular la fecha de aniversario de instalación (a un año de fecha_instalacion)
        $fechaAniversario = $fechaInstalacion->copy()->addYear();

        // Calcular la diferencia en meses entre la fecha actual y el aniversario
        $mesesRestantes = $fechaActual->diffInMonths($fechaAniversario, false);

        // Añadir el cálculo al registro
        $valla->meses_restantes = $mesesRestantes;

        return $valla;
    });

    // Retornar los registros con los meses restantes como respuesta JSON
    return response()->json($vallasConMesesRestantes);
}
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
            $query = Valla::with('contribuyente'); // Agregar la carga de la relación
           
            if ($search) {
                $query->where('lugar_instalacion', 'like', "%$search%")
                       ->orWhere('n_registro', 'like', "%$search%")
                       ->orWhere('opcion', 'like', "%$search%")
                       ->orWhere('donde_instalo', 'like', "%$search%");
            }

            $Vallas = $query->paginate($request->input('per_page', 10));

            return response()->json($Vallas);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getallavisosytableros()
     {
         // Obtener todos los usuarios de la base de datos
         $Vallas = Valla::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($Vallas);
       }


       public function getdeclaracionanualbyId($id)
       {
           // Buscar el usuario por ID
           $Valla = Valla::find($id);
   
           // Verificar si el usuario existe
           if (!$Valla) {
               return response()->json(['message' => 'Declaración no encontrada'], 404);
           }
   
           // Devolver el usuario como respuesta JSON
           return response()->json($Valla);
       }

       public function store(Request $request)
    {
       // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'opcion' => 'required|string|max:255',
            'n_registro' => 'required|string|max:255',
            'fecha_instalacion' => 'required|date',
            'lugar_instalacion' => 'required|string|max:255',
            'donde_instalo' => 'required|string|max:255',
            'base_gravable' => 'required|string|max:255',
            'impuesto_pagar' => 'required|numeric',
            'contribuyente_id' => 'required|integer',
        ]);

        // Si la validación falla, retorna los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Inserción en la base de datos
        $Valla = Valla::create([
            'opcion' => $request->opcion,
            'n_registro' => $request->n_registro,
            'fecha_instalacion' => $request->fecha_instalacion,
            'lugar_instalacion' => $request->lugar_instalacion,
            'donde_instalo' => $request->donde_instalo,
            'base_gravable' => $request->base_gravable,
            'impuesto_pagar' => $request->impuesto_pagar,
            'contribuyente_id' => $request->contribuyente_id,
        ]);

        // Retorna un mensaje de éxito con los datos creados
        return response()->json([
            'message' => 'Valla creada exitosamente',
            'Valla' => $Valla
        ], 201);

    }
    
    public function updatdeclaracionanual(Request $request, $id)
{
    // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'opcion' => 'required|string|max:255',
            'n_registro' => 'required|string|max:255',
            'fecha_instalacion' => 'required|date',
            'lugar_instalacion' => 'required|string|max:255',
            'donde_instalo' => 'required|string|max:255',
            'base_gravable' => 'required|numeric',
            'impuesto_pagar' => 'required|numeric',
            'contribuyente_id' => 'required|integer|exists:contribuyentes,id'
        ]);

        // Retornar errores de validación si los hay
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buscar el registro por ID
        $Valla = Valla::find($id);
        if (!$Valla) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Asignar los valores del request a los campos nuevos
        $Valla->opcion = $request->input('opcion');
        $Valla->n_registro = $request->input('n_registro');
        $Valla->fecha_instalacion = $request->input('fecha_instalacion');
        $Valla->lugar_instalacion = $request->input('lugar_instalacion');
        $Valla->donde_instalo = $request->input('donde_instalo');
        $Valla->base_gravable = $request->input('base_gravable');
        $Valla->impuesto_pagar = $request->input('impuesto_pagar');
        $Valla->contribuyente_id = $request->input('contribuyente_id');

        // Guardar los cambios en la base de datos
        $Valla->save();

        // Retornar el registro actualizado
        return response()->json($Valla, 200);

            
}
    public function deletedeclaracionanual($id)
    {
        $declaracionAnual = Valla::find($id);

        if ($declaracionAnual) {
            $declaracionAnual->delete();
            return response()->json(['message' => 'Aviso exterior eliminado con éxito'], 200);
        }

        return response()->json(['message' => 'Aviso exterior encontrada'], 404);
    }
    public function getallclaracionanual()
    {
        // Obtener todos los usuarios de la base de datos
        $Valla = Valla::all();

        // Devolver los usuarios como respuesta JSON
        return response()->json($Valla);
      }
      public function obtenerDeclaracionesPorNit($nit)
      {

         // Obtenemos el `nit_contribuyente` y `razon_social` desde `declaracionesanul` o cualquiera de las tablas
         $infoGeneral = DB::table('declaracionesanul')
         ->select('nit_contribuyente', 'razon_social')
         ->where('nit_contribuyente', $nit)
         ->first();
        // Si no se encuentra en declaracionesanul, intentar con declaracionesmensuales
        if (!$infoGeneral) {
            $infoGeneral = DB::table('declaracionesmensuales')
                ->select('nit_contribuyente', 'razon_social')
                ->where('nit_contribuyente', $nit)
                ->first();
        }

        // Si no se encuentra en declaracionesmensuales, intentar con declaracionbimestral
        if (!$infoGeneral) {
            $infoGeneral = DB::table('declaracionbimestral')
                ->select('nit_contribuyente', 'razon_social')
                ->where('nit_contribuyente', $nit)
                ->first();
        }
          $data = [
              'info_general' => $infoGeneral,
              'declaraciones_anuales' => DB::table('declaracionesanul')
                  ->select('total_industria_comercio', 'impuesto_avisos_tableros')
                  ->where('nit_contribuyente', $nit)
                  ->get(),
  
              'declaraciones_mensuales' => DB::table('declaracionesmensuales')
                  ->select('autoretencion_impuesto_industria_comercio', 'mas_autoretenciones_impuestos_avisos_tableros')
                  ->where('nit_contribuyente', $nit)
                  ->get(),
  
              'declaraciones_bimestrales' => DB::table('declaracionbimestral')
                  ->select('autoretencion_impuesto_industria_comercio', 'mas_autoretenciones_impuestos_avisos_tableros')
                  ->where('nit_contribuyente', $nit)
                  ->get(),
          ];
  
          return response()->json($data);
      }
}

