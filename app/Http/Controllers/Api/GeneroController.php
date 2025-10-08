<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genero;
use Exception;

class GeneroController extends Controller
{
    public function index()
    {
        try {
            $data = Genero::all();
            return $this->successResponse($data, 'Géneros obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
