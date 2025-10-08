<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id') ?? null;

        $rules = [
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento' => [
                'required',
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
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'nullable|email|max:150',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            foreach ($rules as $key => $rule) {
                if (is_string($rule)) {
                    $rules[$key] = str_replace('required|', 'sometimes|', $rule);
                } elseif (is_array($rule)) {
                    // Caso especial para numero_documento
                    if ($key === 'numero_documento') {
                        $rules[$key][0] = 'sometimes';
                    }
                }
            }

            $rules['foto'] = 'sometimes|image|mimes:jpg,jpeg,png|max:2048';
        }

        return $rules;
    }
}
