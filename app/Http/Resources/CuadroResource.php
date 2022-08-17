<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Http\Resources\SalaResource;
use App\Http\Resources\PaisResource;

class CuadroResource extends JsonResource
{
    public $with = [
        'meta' => ['count' => 1],
        'status' => 'success',
        'code' => '200',
        'errors' => ''
    ];
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'tipo' => 'Cuadro',
            'atributos' => $this->atributos($request),
            'relaciones' => [
                'sala' => SalaResource::make($this->sala),
                'pais_procedencia' => PaisResource::make($this->procedencia),
            ],
            'links' => [
                'self' => route('cuadros.show', [$this->id()]),
                'img' => $this->img_url
            ]
        ];
    }

    public static function collection($resource)
    {
        $collection = parent::collection($resource);
        $result['data'] = $collection;
        $result = array_merge($result, (new static($resource))->with(request()));
        $result['meta']['count'] = count($collection);
        return $result;
    }

    public function atributos(Request $request){
        $attrs = [];
        if($request->query('fields')){
            $fields = explode(',',$request->query('fields'));
            foreach($fields as $field){
                $attrs[$field] = $this->{$field};
            }
        }else{
            $attrs = [
                'id' => (string) $this->id(),
                'nombre' => $this->nombre,
                'author' => $this->autor,
                'precio' => $this->precio,
                'anio_creacion' => $this->anio_creacion,
                'alto' => $this->alto,
                'ancho' => $this->ancho,
            ];
        }

        return $attrs;
    }
}
