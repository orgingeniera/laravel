<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AvisosYTableroImport;
use Maatwebsite\Excel\Facades\Excel;
//use App\Models\Avisosytablero;
use App\Models\Valla;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VallasController extends Controller
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
            $query = Valla::with('contribuyente'); // Agregar la carga de la relación
           
            if ($search) {
                $query->where('razon_social', 'like', "%$search%")
                    ->orWhere('nit_contribuyente', 'like', "%$search%");
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
            'n_declaracion' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
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
    $Valla = Valla::find($id);
    if (!$Valla) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $Valla->n_declaracion = $request->input('n_declaracion');
    $Valla->vigencia = $request->input('vigencia');
    $Valla->fecha_declaracion = $request->input('fecha_declaracion');
    $Valla->nit_contribuyente = $request->input('nit_contribuyente');
    $Valla->razon_social = $request->input('razon_social');
    $Valla->regimen = $request->input('regimen');
    $Valla->direccion = $request->input('direccion');
    $Valla->ciudad = $request->input('ciudad');
    $Valla->correo_electronico = $request->input('correo_electronico');
    $Valla->total_ingresos_nacionales = $request->input('total_ingresos_nacionales');
    $Valla->menos_ingresos_fuera_municipio = $request->input('menos_ingresos_fuera_municipio');
    $Valla->total_ingresos_municipio = $request->input('total_ingresos_municipio');
    $Valla->menos_ingresos_rebajas = $request->input('menos_ingresos_rebajas');
    $Valla->menos_ingresos_exportaciones = $request->input('menos_ingresos_exportaciones');
    $Valla->menos_ingresos_venta_activos = $request->input('menos_ingresos_venta_activos');
    $Valla->menos_ingresos_no_gravados = $request->input('menos_ingresos_no_gravados');
    $Valla->menos_ingresos_exentos = $request->input('menos_ingresos_exentos');
    $Valla->total_ingresos_gravables = $request->input('total_ingresos_gravables');
    $Valla->total_impuesto = $request->input('total_impuesto');
    $Valla->capacidad_kw = $request->input('capacidad_kw');
    $Valla->impuesto_ley_56 = $request->input('impuesto_ley_56');
    $Valla->total_industria_comercio = $request->input('total_industria_comercio');
    $Valla->impuesto_avisos_tableros = $request->input('impuesto_avisos_tableros');
    $Valla->pago_unidades_adicionales = $request->input('pago_unidades_adicionales');
    $Valla->sobretasa_bomberil = $request->input('sobretasa_bomberil');
    $Valla->sobretasa_seguridad = $request->input('sobretasa_seguridad');
    $Valla->total_impuesto_cargo = $request->input('total_impuesto_cargo');


    // Guardar los cambios en la base de datos
    $Valla->save();

    // Retornar el usuario actualizado
    return response()->json($Valla, 200);
}
    public function deletedeclaracionanual($id)
    {
        $declaracionAnual = Valla::find($id);

        if ($declaracionAnual) {
            $declaracionAnual->delete();
            return response()->json(['message' => 'Declaración anual eliminado con éxito'], 200);
        }

        return response()->json(['message' => 'Declaración anual no encontrada'], 404);
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

