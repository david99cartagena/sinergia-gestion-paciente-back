<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id') ?? null;

        return [
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento' => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'string',
                'max:50',
                Rule::unique('pacientes', 'numero_documento')->ignore($id),
            ],
            'nombre1' => 'required|string|max:100',
            'nombre2' => 'nullable|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'nullable|string|max:100',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => [
                'required',
                'exists:municipios,id',
                function ($attribute, $value, $fail) {
                    $departamentoId = $this->input('departamento_id');
                    if ($departamentoId) {
                        $exists = DB::table('municipios')
                            ->where('id', $value)
                            ->where('departamento_id', $departamentoId)
                            ->exists();
                        if (!$exists) {
                            $fail('El municipio seleccionado no pertenece al departamento indicado.');
                        }
                    }
                },
            ],
            'correo' => 'nullable|email|max:150',

            // FOTO OPCIONAL
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120'
            ],
        ];
    }
}
