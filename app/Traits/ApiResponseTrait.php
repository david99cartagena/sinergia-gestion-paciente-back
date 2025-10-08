<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait ApiResponseTrait
{
    protected function successResponse($data = [], $msg = 'Operación exitosa', $status = 200)
    {
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ], $status);
    }

    protected function errorResponse(Exception $e, $msg = 'Error interno del servidor', $status = 500)
    {
        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'error' => $e->getMessage(),
        ], $status);
    }

    protected function notFoundResponse($msg = 'Recurso no encontrado')
    {
        return response()->json([
            'status' => 404,
            'msg' => $msg,
        ], 404);
    }
}
