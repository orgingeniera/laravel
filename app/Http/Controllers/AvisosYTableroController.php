<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AvisosYTableroImport;
use Maatwebsite\Excel\Facades\Excel;
//use App\Models\Avisosytablero;
use App\Models\DeclaracionAnul;
use Illuminate\Support\Facades\Validator;


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

            $declaracionAnuls = $query->paginate($request->input('per_page', 10));

            return response()->json($declaracionAnuls);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getallavisosytableros()
     {
         // Obtener todos los usuarios de la base de datos
         $declaracionAnuls = DeclaracionAnul::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($declaracionAnuls);
       }


       public function getdeclaracionanualbyId($id)
       {
           // Buscar el usuario por ID
           $declaracionAnul = DeclaracionAnul::find($id);
   
           // Verificar si el usuario existe
           if (!$declaracionAnul) {
               return response()->json(['message' => 'Declaración no encontrada'], 404);
           }
   
           // Devolver el usuario como respuesta JSON
           return response()->json($declaracionAnul);
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
        $declaracionAnul = DeclaracionAnul::create([
            
            'n_declaracion' => $request->n_declaracion,
            'vigencia' => $request->vigencia,
            'fecha_declaracion' => $request->fecha_declaracion,
            'nit_contribuyente' => $request->nit_contribuyente,
            'razon_social' => $request->razon_social,
            'regimen' => $request->regimen,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'correo_electronico' => $request->correo_electronico,
            'total_ingresos_nacionales' => $request->total_ingresos_nacionales,
            'menos_ingresos_fuera_municipio' => $request->menos_ingresos_fuera_municipio,
            'total_ingresos_municipio' => $request->total_ingresos_municipio,
            'menos_ingresos_rebajas' => $request->menos_ingresos_rebajas,
            'menos_ingresos_exportaciones' => $request->menos_ingresos_exportaciones,
            'menos_ingresos_venta_activos' => $request->menos_ingresos_venta_activos,
            'menos_ingresos_no_gravados' => $request->menos_ingresos_no_gravados,
            'menos_ingresos_exentos' => $request->menos_ingresos_exentos,
            'total_ingresos_gravables' => $request->total_ingresos_gravables,
            'total_impuesto' => $request->total_impuesto,
            'capacidad_kw' => $request->capacidad_kw,
            'impuesto_ley_56' => $request->impuesto_ley_56,
            'total_industria_comercio' => $request->total_industria_comercio,
            'impuesto_avisos_tableros' => $request->impuesto_avisos_tableros,
            'pago_unidades_adicionales' => $request->pago_unidades_adicionales,
            'sobretasa_bomberil' => $request->sobretasa_bomberil,
            'sobretasa_seguridad' => $request->sobretasa_seguridad,
            'total_impuesto_cargo' => $request->total_impuesto_cargo,  // Encriptación de la contraseña
        ]);

        // Retorna un mensaje de éxito con los datos del usuario creado
        return response()->json([
            'message' => 'DeclaracionAnul creada exitosamente',
            'declaracionAnul' => $declaracionAnul
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
    $declaracionAnul = DeclaracionAnul::find($id);
    if (!$declaracionAnul) {
        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    $declaracionAnul->n_declaracion = $request->input('n_declaracion');
    $declaracionAnul->vigencia = $request->input('vigencia');
    $declaracionAnul->fecha_declaracion = $request->input('fecha_declaracion');
    $declaracionAnul->nit_contribuyente = $request->input('nit_contribuyente');
    $declaracionAnul->razon_social = $request->input('razon_social');
    $declaracionAnul->regimen = $request->input('regimen');
    $declaracionAnul->direccion = $request->input('direccion');
    $declaracionAnul->ciudad = $request->input('ciudad');
    $declaracionAnul->correo_electronico = $request->input('correo_electronico');
    $declaracionAnul->total_ingresos_nacionales = $request->input('total_ingresos_nacionales');
    $declaracionAnul->menos_ingresos_fuera_municipio = $request->input('menos_ingresos_fuera_municipio');
    $declaracionAnul->total_ingresos_municipio = $request->input('total_ingresos_municipio');
    $declaracionAnul->menos_ingresos_rebajas = $request->input('menos_ingresos_rebajas');
    $declaracionAnul->menos_ingresos_exportaciones = $request->input('menos_ingresos_exportaciones');
    $declaracionAnul->menos_ingresos_venta_activos = $request->input('menos_ingresos_venta_activos');
    $declaracionAnul->menos_ingresos_no_gravados = $request->input('menos_ingresos_no_gravados');
    $declaracionAnul->menos_ingresos_exentos = $request->input('menos_ingresos_exentos');
    $declaracionAnul->total_ingresos_gravables = $request->input('total_ingresos_gravables');
    $declaracionAnul->total_impuesto = $request->input('total_impuesto');
    $declaracionAnul->capacidad_kw = $request->input('capacidad_kw');
    $declaracionAnul->impuesto_ley_56 = $request->input('impuesto_ley_56');
    $declaracionAnul->total_industria_comercio = $request->input('total_industria_comercio');
    $declaracionAnul->impuesto_avisos_tableros = $request->input('impuesto_avisos_tableros');
    $declaracionAnul->pago_unidades_adicionales = $request->input('pago_unidades_adicionales');
    $declaracionAnul->sobretasa_bomberil = $request->input('sobretasa_bomberil');
    $declaracionAnul->sobretasa_seguridad = $request->input('sobretasa_seguridad');
    $declaracionAnul->total_impuesto_cargo = $request->input('total_impuesto_cargo');


    // Guardar los cambios en la base de datos
    $declaracionAnul->save();

    // Retornar el usuario actualizado
    return response()->json($declaracionAnul, 200);
}
}

