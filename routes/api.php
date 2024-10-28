<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvisosYTableroController;
use App\Http\Controllers\DeclaracionesanulImageController;

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
    Route::middleware('auth:api')->get('/alluser', [AuthController::class, 'alluser']);
    Route::middleware('auth:api')->post('/insertusers', [UserController::class, 'store']);
    Route::middleware('auth:api')->get('/getallusers', [UserController::class, 'getallusers']);
    Route::middleware('auth:api')->get('/getuserbyId/{id}', [UserController::class, 'getuserbyId']);
    Route::middleware('auth:api')->put('/updateuser/{id}', [UserController::class, 'updateuser']);
    Route::middleware('auth:api')->put('/deleteusers/{id}/delete', [UserController::class, 'deleteuser']);
   //---------------------------
   
    //para cargar la informacion del excel
    Route::middleware('auth:api')->post('/upload-excel', [AvisosYTableroController::class, 'uploadExcel']);
    // Otras rutas protegidas

    //api avisos y tableros
    Route::middleware('auth:api')->get('/getallavisosytableros', [AvisosYTableroController::class, 'getallavisosytableros']);
    Route::middleware('auth:api')->get('/allavisosytablero', [AvisosYTableroController::class, 'allavisosytablero']);
    Route::middleware('auth:api')->get('/getdeclaracionanualbyid/{id}', [AvisosYTableroController::class, 'getdeclaracionanualbyId']);
    Route::middleware('auth:api')->post('/insertdeclaracionanual', [AvisosYTableroController::class, 'store']);
    Route::middleware('auth:api')->put('/updatdeclaracionanual/{id}', [AvisosYTableroController::class, 'updatdeclaracionanual']);
    Route::middleware('auth:api')->delete('/deletedeclaracionanual/{id}/delete', [AvisosYTableroController::class, 'deletedeclaracionanual']);
    Route::middleware('auth:api')->get('/getallclaracionanual', [AvisosYTableroController::class, 'getallclaracionanual']);
     //-------
    

     //api insertar imagenes
     Route::middleware('auth:api')->post('/declaracionesanul-images', [DeclaracionesanulImageController::class, 'store']);
    //-------
});
Route::get('/check', function () {
    return response()->json(['message' => 'OK']);
});
//usuarios iniciar sesion
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
//Fin usuarios