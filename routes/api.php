<?php

use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\GeneroController;
use App\Http\Controllers\Api\MunicipioController;
use App\Http\Controllers\Api\TipoDocumentoController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// Rutas públicas
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

// Rutas protegidas con JWT
Route::middleware(['auth:api'])->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);

    // Listados para selects
    Route::get('tipo_documentos', [TipoDocumentoController::class, 'index']);
    Route::get('generos', [GeneroController::class, 'index']);
    Route::get('departamentos', [DepartamentoController::class, 'index']);
    Route::get('municipios/{departamento_id}', [MunicipioController::class, 'getByDepartamento']);

    // CRUD Pacientes
    Route::get('pacientes', [PatientController::class, 'index']);
    Route::post('pacientes', [PatientController::class, 'store']);
    Route::get('pacientes/{id}', [PatientController::class, 'show']);
    Route::middleware('handle.put.multipart')->put('pacientes/{id}', [PatientController::class, 'update']);
    Route::delete('pacientes/{id}', [PatientController::class, 'destroy']);
});
