<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamento;
use Exception;

class DepartamentoController extends Controller
{
    public function index()
    {
        try {
            $data = Departamento::all();
            return $this->successResponse($data, 'Departamentos obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
