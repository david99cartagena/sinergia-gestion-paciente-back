<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Municipio;
use Exception;

class MunicipioController extends Controller
{
    public function getByDepartamento($departamento_id)
    {
        try {
            $data = Municipio::where('departamento_id', $departamento_id)->get();
            return $this->successResponse($data, 'Municipios obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
