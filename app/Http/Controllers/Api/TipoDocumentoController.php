<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use Exception;

class TipoDocumentoController extends Controller
{
    public function index()
    {
        try {
            $data = TipoDocumento::all(); // OK
            return $this->successResponse($data, 'Tipos de documento obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
