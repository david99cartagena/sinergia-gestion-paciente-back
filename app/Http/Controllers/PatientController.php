<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Http\Requests\PacienteRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 15);
            $query = Paciente::with(['tipoDocumento', 'genero', 'departamento', 'municipio']);

            if ($q = $request->get('q')) {
                $query->where(function ($r) use ($q) {
                    $r->where('nombre1', 'like', "%$q%")
                        ->orWhere('apellido1', 'like', "%$q%")
                        ->orWhere('correo', 'like', "%$q%")
                        ->orWhere('numero_documento', 'like', "%$q%");
                });
            }

            $query->orderBy('updated_at', 'desc');

            $data = $query->paginate($perPage);
            return $this->successResponse($data, 'Pacientes obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function show($id)
    {
        try {
            $pac = Paciente::with(['tipoDocumento', 'genero', 'departamento', 'municipio'])
                ->findOrFail($id);

            return $this->successResponse($pac, 'Paciente encontrado correctamente');
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Paciente no encontrado');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(PacienteRequest $request)
    {
        try {
            $data = $request->validated();

            // Procesar foto opcional
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $file = $request->file('foto');
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $data['foto'] = $file->storeAs('pacientes', $filename, 'public');
            } else {
                $data['foto'] = ""; // Si no se envía, dejar vacío
            }

            $paciente = Paciente::create($data);
            $paciente->load(['tipoDocumento', 'genero', 'departamento', 'municipio']);

            return $this->successResponse($paciente, 'Paciente creado exitosamente', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(PacienteRequest $request, $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Eliminar foto anterior si existe
                if ($paciente->foto && Storage::disk('public')->exists($paciente->foto)) {
                    Storage::disk('public')->delete($paciente->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $data['foto'] = $file->storeAs('pacientes', $filename, 'public');
            } elseif ($request->has('foto') && empty($request->file('foto'))) {
                // Si se envía vacío, borrar foto anterior y dejar vacío
                if ($paciente->foto && Storage::disk('public')->exists($paciente->foto)) {
                    Storage::disk('public')->delete($paciente->foto);
                }
                $data['foto'] = "";
            } else {
                // No se envía el campo, no tocar foto
                unset($data['foto']);
            }

            $paciente->update($data);
            $paciente->refresh()->load(['tipoDocumento', 'genero', 'departamento', 'municipio']);

            return $this->successResponse($paciente, 'Paciente actualizado correctamente');
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Paciente no encontrado');
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy($id)
    {
        try {
            $pac = Paciente::findOrFail($id);

            if ($pac->foto && Storage::disk('public')->exists($pac->foto)) {
                Storage::disk('public')->delete($pac->foto);
            }

            $pac->delete();

            return $this->successResponse(null, 'Paciente eliminado correctamente');
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse('Paciente no encontrado');
        } catch (Exception $e) {
            return $this->errorResponse($e, 'Error al eliminar el paciente');
        }
    }
}
