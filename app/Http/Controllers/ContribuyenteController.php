<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Asegúrate de incluir esta línea
class ContribuyenteController extends Controller
{
    /**
     * Obtener todos los contribuyentes.
     */
    public function countContribuyente()
    {
        // Contar el número de usuarios en la tabla 'users'
        $userCount = Contribuyente::count();

        // Devolver el conteo como respuesta JSON
        return response()->json(['count' => $userCount], 200);
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

    public function allcontribuyente(Request $request)
    {

            $search = $request->input('search');
            $query = Contribuyente::query();
           
            if ($search) {
                $query->where('nombre', 'like', "%$search%")
                    ->orWhere('apellido', 'like', "%$search%")
                    ->orWhere('identificacion', 'like', "%$search%");
            }

            $Contribuyentes = $query->paginate($request->input('per_page', 10));

            return response()->json($Contribuyentes);
        }
     // Método para obtener todos los usuarios sin paginación
     public function getallavisosytableros()
     {
         // Obtener todos los usuarios de la base de datos
         $Contribuyentes = Contribuyente::all();
 
         // Devolver los usuarios como respuesta JSON
         return response()->json($Contribuyentes);
       }


       public function getcontribuyentebyId($id)
       {
           // Buscar el usuario por ID
           $Contribuyente = Contribuyente::find($id);
   
           // Verificar si el usuario existe
           if (!$Contribuyente) {
               return response()->json(['message' => 'Declaración no encontrada'], 404);
           }
   
           // Devolver el usuario como respuesta JSON
           return response()->json($Contribuyente);
       }

       public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipo_identificacion' => 'required|string|max:255',
            'identificacion' => 'required|string|max:255',
            'dv' => 'nullable|string|max:10', // Si 'dv' es opcional
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:50',
            'municipio' => 'required|string|max:50',
            'departamento' => 'required|string|max:50',
        ]);

        // Si la validación falla, retorna los errores
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

    // Inserción del contribuyente en la base de datos
    $Contribuyente = Contribuyente::create([
    'nombre' => $request->nombre,
    'apellido' => $request->apellido,
    'tipo_identificacion' => $request->tipo_identificacion,
    'identificacion' => $request->identificacion,
    'dv' => $request->dv,
    'telefono' => $request->telefono,
    'direccion' => $request->direccion,
    'municipio' => $request->municipio,
    'departamento' => $request->departamento,
    ]);

        // Retorna un mensaje de éxito con los datos del contribuyente creado
        return response()->json([
            'message' => 'Contribuyente creada exitosamente',
            'Contribuyente' => $Contribuyente
        ], 201);

    }
    
    public function updatecontribuyente(Request $request, $id)
{
    // Validación de los datos recibidos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipo_identificacion' => 'required|string|max:50',
            'identificacion' => 'required|string|max:50',
            'dv' => 'required|string|max:10',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'municipio' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
        ]);

        // Retornar errores de validación si los hay
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Buscar el contribuyente por ID
        $Contribuyente = Contribuyente::find($id);
        if (!$Contribuyente) {
            return response()->json(['message' => 'Contribuyente no encontrado'], 404);
        }

        // Actualizar los campos del contribuyente
        $Contribuyente->nombre = $request->input('nombre');
        $Contribuyente->apellido = $request->input('apellido');
        $Contribuyente->tipo_identificacion = $request->input('tipo_identificacion');
        $Contribuyente->identificacion = $request->input('identificacion');
        $Contribuyente->dv = $request->input('dv');
        $Contribuyente->telefono = $request->input('telefono');
        $Contribuyente->direccion = $request->input('direccion');
        $Contribuyente->municipio = $request->input('municipio');
        $Contribuyente->departamento = $request->input('departamento');

        // Guardar los cambios en la base de datos
        $Contribuyente->save();

        // Retornar el contribuyente actualizado
        return response()->json($Contribuyente, 200);

}
    public function deletecontribuyente($id)
    {
        $declaracionAnual = Contribuyente::find($id);

        if ($declaracionAnual) {
            $declaracionAnual->delete();
            return response()->json(['message' => 'Contribuyente eliminado con éxito'], 200);
        }

        return response()->json(['message' => 'Contribuyente no encontrada'], 404);
    }
    public function getallcontribuyentes()
    {
        // Obtener todos los usuarios de la base de datos
        $Contribuyente = Contribuyente::all();

        // Devolver los usuarios como respuesta JSON
        return response()->json($Contribuyente);
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
