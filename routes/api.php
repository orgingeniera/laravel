<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvisosYTableroController;
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
   
   
    //para cargar la informacion del excel
    Route::middleware('auth:api')->post('/upload-excel', [AvisosYTableroController::class, 'uploadExcel']);
    // Otras rutas protegidas
});
Route::get('/check', function () {
    return response()->json(['message' => 'OK']);
});
//usuarios iniciar sesion
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
//Fin usuarios