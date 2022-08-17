<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Sala;

class UpdateCuadroRequest extends FormRequest
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
            'anio_creacion'	=> 'date_format:Y-m-d',
            'procedencia' => 'internacional_code',
            'sala' => 'in:'.implode(',',Sala::all()->pluck('id')->toArray())
        ];
    }

    public function messages()
    {
        return [
            'sala.in' => 'La sala solicitada no existe',
            'procedencia.internacional_code' => 'No es un codigo internacional valido'
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
