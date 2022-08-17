<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Sala;

class FiltersCuadroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'filters' => 'array:autor,maxPrecio,minPrecio,maxAlto,minAlto,maxAncho,minAncho,maxCreacion,minCreacion,sala,procedencia',
            'fields' => 'cuadro_fields',
            'filters.maxPrecio' => 'numeric',
            'filters.minPrecio' => 'numeric',
            'filters.maxAlto' => 'numeric',
            'filters.minAlto' => 'numeric',
            'filters.maxAncho' => 'numeric',
            'filters.minAncho' => 'numeric',
            'filters.maxCreacion' => 'date_format:Y-m-d',
            'filters.minCreacion' => 'date_format:Y-m-d',
            'filters.sala' => 'in:'.implode(',',Sala::all()->pluck('id')->toArray()),
            'filters.procedencia' => 'internacional_code'

        ];
    }

    public function messages()
    {
        return [
            'filters.array' => 'El criterio del filtro es incorrecto',
            'fields.cuadro_fields' => 'Lista de campos incorrecta',
            'filters.sala.in' => 'La sala solicitada no existe',
            'filters.procedencia.internacional_code' => 'No es un codigo internacional valido'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'data' => '', 
                'status' => 'error', 
                'code' => '422', 
                'errors' => $validator->errors()
            ]
        , 422));
    }

}
