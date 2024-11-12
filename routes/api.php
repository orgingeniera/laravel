<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvisosYTableroController;
use App\Http\Controllers\DeclaracionmensualController;
use App\Http\Controllers\DeclaracionesanulImageController;
use App\Http\Controllers\DeclaracionBimestralController;
use App\Http\Controllers\ContribuyenteController;
use App\Http\Controllers\VallasController;
use App\Http\Controllers\VallasImageController;
use App\Http\Controllers\UvtController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(\Tymon\JWTAuth\Http\Middleware\Authenticate::class)->group(function () {
  
    //api para usuarios
    Route::middleware('auth:api')->group(function () {
        Route::get('/alluser', [AuthController::class, 'alluser']);
        Route::post('/insertusers', [UserController::class, 'store']);
        Route::get('/getallusers', [UserController::class, 'getallusers']);
        Route::get('/getuserbyId/{id}', [UserController::class, 'getuserbyId']);
        Route::put('/updateuser/{id}', [UserController::class, 'updateuser']);
        Route::put('/deleteusers/{id}/delete', [UserController::class, 'deleteuser']);
        Route::get('/usercount', [UserController::class, 'countUsers']);
    });
    /*Route::middleware('auth:api')->get('/alluser', [AuthController::class, 'alluser']);
    Route::middleware('auth:api')->post('/insertusers', [UserController::class, 'store']);
    Route::middleware('auth:api')->get('/getallusers', [UserController::class, 'getallusers']);
    Route::middleware('auth:api')->get('/getuserbyId/{id}', [UserController::class, 'getuserbyId']);
    Route::middleware('auth:api')->put('/updateuser/{id}', [UserController::class, 'updateuser']);
    Route::middleware('auth:api')->put('/deleteusers/{id}/delete', [UserController::class, 'deleteuser']);
    */
    //---------------------------
   
    //para cargar la informacion del excel
    Route::middleware('auth:api')->post('/upload-excel', [AvisosYTableroController::class, 'uploadExcel']);
    Route::middleware('auth:api')->post('/upload-excel-mensual', [DeclaracionmensualController::class, 'uploadExcel']);
    Route::middleware('auth:api')->post('/upload-excel-bimestral', [DeclaracionBimestralController::class, 'uploadExcel']);
    
    // Otras rutas protegidas

    //api avisos y tableros
    Route::middleware('auth:api')->group(function () {
        Route::get('/countdeclaracionanul', [AvisosYTableroController::class, 'countDeclaracionAnul']);
        Route::get('/getallavisosytableros', [AvisosYTableroController::class, 'getallavisosytableros']);
        Route::get('/allavisosytablero', [AvisosYTableroController::class, 'allavisosytablero']);
        Route::get('/getdeclaracionanualbyid/{id}', [AvisosYTableroController::class, 'getdeclaracionanualbyId']);
        Route::post('/insertdeclaracionanual', [AvisosYTableroController::class, 'store']);
        Route::put('/updatdeclaracionanual/{id}', [AvisosYTableroController::class, 'updatdeclaracionanual']);
        Route::delete('/deletedeclaracionanual/{id}/delete', [AvisosYTableroController::class, 'deletedeclaracionanual']);
        Route::get('/getallclaracionanual', [AvisosYTableroController::class, 'getallclaracionanual']);
        Route::get('/obtenerDeclaracionesPorNit/{nit}/{vigencia}', [AvisosYTableroController::class, 'obtenerDeclaracionesPorNit']);    
        Route::delete('/eliminarDeclaracionesAnul', [AvisosYTableroController::class, 'eliminarDeclaracionesAnul']);
    });
   
    //-------

     //api declaracion mensual
     Route::middleware('auth:api')->get('/alldeclaracionmensual', [DeclaracionmensualController::class, 'alldeclaracionmensual']);
     Route::middleware('auth:api')->post('/insertdeclaracionmensual', [DeclaracionmensualController::class, 'store']);
     Route::middleware('auth:api')->get('/getdeclaracionmensualbyid/{id}', [DeclaracionmensualController::class, 'getdeclaracionmensualbyid']);
     Route::middleware('auth:api')->put('/updatdeclaracionmensual/{id}', [DeclaracionmensualController::class, 'updatdeclaracionmensual']);
     Route::middleware('auth:api')->delete('/deletedeclaracionmensual/{id}/delete', [DeclaracionmensualController::class, 'deletedeclaracionmensual']);
     Route::middleware('auth:api')->get('/getAlldeclaracionanualbynit/{id}', [DeclaracionmensualController::class, 'getAllDeclaracionAnualByNit']);
     Route::middleware('auth:api')->get('/declaracionmensualcontroller', [DeclaracionmensualController::class, 'getdeclaracionmensualexportar']);
     Route::middleware('auth:api')->delete('/eliminarDeclaracionesMensuales', [DeclaracionmensualController::class, 'eliminarDeclaracionesMensuales']);

     
     //-----------
     //api declaracion bimestral
     Route::middleware('auth:api')->get('/alldeclaracionbimestral', [DeclaracionBimestralController::class, 'allDeclaracionBimestral']);
     Route::middleware('auth:api')->post('/insertdeclaracionbimestral', [DeclaracionBimestralController::class, 'store']);
     Route::middleware('auth:api')->put('/updatdeclaracionbimestral/{id}', [DeclaracionBimestralController::class, 'updatDeclaracionBimestral']);
     Route::middleware('auth:api')->get('/getdeclaracionbimestralbyid/{id}', [DeclaracionBimestralController::class, 'getdeclaracionBimestralbyid']);
     Route::middleware('auth:api')->delete('/deletedeclaracionbimestral/{id}/delete', [DeclaracionBimestralController::class, 'deletedeclaracionBimestral']);
     Route::middleware('auth:api')->get('/getallclaracionbimestral', [DeclaracionBimestralController::class, 'getallclaracionBimestral']);
     Route::middleware('auth:api')->get('/getAlldeclaracionbimestralbynit/{id}', [DeclaracionBimestralController::class, 'getAllDeclaracionBimestralByNit']);
     Route::middleware('auth:api')->delete('/eliminarDeclaracionesBimestrales', [DeclaracionBimestralController::class, 'eliminarDeclaracionesBimestrales']);

     //----- api contribuyente
     Route::middleware('auth:api')->group(function () {
        Route::get('/contribuyentecount', [ContribuyenteController::class, 'countContribuyente']);
        Route::get('/getallcontribuyentes', [ContribuyenteController::class, 'getallcontribuyentes']);
        Route::get('/contribuyentes', [ContribuyenteController::class, 'allcontribuyente']); // Obtener todos los contribuyentes
        Route::post('/contribuyentes', [ContribuyenteController::class, 'store']); // Crear un nuevo contribuyente
        Route::get('/contribuyentes/{id}', [ContribuyenteController::class, 'getcontribuyentebyId']); // Obtener un contribuyente específico
        Route::put('/contribuyentes/{id}', [ContribuyenteController::class, 'updatecontribuyente']); // Actualizar un contribuyente
        Route::delete('/contribuyentes/{id}', [ContribuyenteController::class, 'deletecontribuyente']); // Eliminar un contribuyente
    });
  //--------------API VALLAS
    Route::middleware('auth:api')->group(function () {
        Route::get('/vallas/cercanos-anio', [VallasController::class, 'registrosCercanosACumplirAnio']);
        Route::get('/countVallas', [VallasController::class, 'countVallas']);
        Route::get('/getallvallas', [VallasController::class, 'getallavisosytableros']);
        Route::get('/vallas', [VallasController::class, 'allavisosytablero']);
        Route::get('/vallas/{id}', [VallasController::class, 'getdeclaracionanualbyId']);
        Route::post('/vallas', [VallasController::class, 'store']);
        Route::put('/vallas/{id}', [VallasController::class, 'updatdeclaracionanual']);
        Route::delete('/vallas/{id}/delete', [VallasController::class, 'deletedeclaracionanual']);
        Route::get('/vallasgetall', [VallasController::class, 'getallclaracionanual']);
        Route::get('/vallas/{nit}', [VallasController::class, 'obtenerDeclaracionesPorNit']);
         //api insertar imagenes
        Route::middleware('auth:api')->delete('vallas-images/{id}', [VallasImageController::class, 'deleteImage']);
        Route::middleware('auth:api')->get('/vallas-images/{vallas_id}', [VallasImageController::class, 'getImages']);
        Route::middleware('auth:api')->post('/vallas-images', [VallasImageController::class, 'store']);
    //-------
    });

    //--------------API UVT
    Route::middleware('auth:api')->group(function () {
        Route::get('/uvt', [UvtController::class, 'index']);
        Route::put('/uvt/{id}', [UvtController::class, 'update']);   //-------
    });

     //--------------
     
     //api insertar imagenes
     Route::middleware('auth:api')->get('/declaracionesanul-images/{declaracionesanul_id}', [DeclaracionesanulImageController::class, 'getImages']);
     Route::middleware('auth:api')->post('/declaracionesanul-images', [DeclaracionesanulImageController::class, 'store']);
    //-------
});
Route::get('/check', function () {
    return response()->json(['message' => 'OK']);
});
//usuarios iniciar sesion
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/getallvallas', [VallasController::class, 'getallavisosytableros']);
//Fin usuarios