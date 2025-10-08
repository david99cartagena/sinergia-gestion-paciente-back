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
                        ->orWhere('numero_documento', 'like', "%$q%");
                });
            }

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
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pacientes', 'public');
            $data['foto'] = $fotoPath;
        }

        $paciente = Paciente::create($data);

        return response()->json([
            'message' => 'Paciente creado exitosamente',
            'data' => $paciente
        ], 201);
    }

    public function update(PacienteRequest $request, $id)
    {

        $paciente = Paciente::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {

            // eliminar foto anterior si existe
            if ($paciente->foto && \Storage::disk('public')->exists($paciente->foto)) {
                \Storage::disk('public')->delete($paciente->foto);
            }

            // guardar foto
            $file = $request->file('foto');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('pacientes', $filename, 'public');
        }

        $paciente->update($data);
        $paciente->refresh();

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'data' => $paciente
        ]);
    }


    public function destroy($id)
    {
        try {
            $pac = Paciente::findOrFail($id);

            if ($pac->foto) {
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
