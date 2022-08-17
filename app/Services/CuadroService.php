<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Cuadro;
use App\Models\Pais;

class CuadroService
{
    /**
     * Espera $filters Array donde casa llave se corresponda con un scoope definido en el modelo y cada valor asignado a tal scoope
     * Espera $page Int y $per_page Int con ambos se construye un paginado si no son nulos
     * Espera $sort String que debe coincidir con un campo
     * Devuelve un Eloquent Query Builder
     */
    public function find($filters, $per_page = 10, $sort = null, $direction = 'asc'){
        $query = Cuadro::query();

        //Las llaves se deben corresponder con un scoope definido en el modelo
        foreach($filters as $type => $value){
            $query->{$type}($value);
        }

        //Se ordena si viene $sort != null
        if($sort){
            //Si el orden tiene un . se asume que es un orden relacional
            if(!str_contains($sort, '.')){
                $query->orderBy($sort, $direction);
            }else{
                $query->orderByPowerJoins($sort, $direction);
            }
        }

        //dd($query->toSql());
        return $query->paginate($per_page);
    }

    public function store($request){
        $cuadro = new Cuadro();
        $cuadro->autor = $request->autor;
        $cuadro->nombre = $request->nombre;
        $cuadro->precio = $request->precio??NULL;
        $cuadro->anio_creacion = $request->anio_creacion;
        $cuadro->alto = $request->alto;
        $cuadro->ancho = $request->ancho;
        $cuadro->pais_procedencia_id = Pais::getByCode($request->procedencia)->id;
        $cuadro->sala_id = $request->sala;
        $cuadro->img_url = $request->img_url??NULL;
        $cuadro->save();
        return $cuadro;
    }

    public function update($request, Cuadro $cuadro){
        $data = $request->all();
        if(isset($data['procedencia'])){
            $data['pais_procedencia_id'] = Pais::getByCode($data['procedencia'])->id;
            unset($data['procedencia']);
        }
        if(isset($data['sala'])){
            $data['sala_id'] = $data['sala'];
            unset($data['sala']);
        }
        $cuadro->update($data);
        return $cuadro;
    }

    public function delete(Cuadro $cuadro){
        return $cuadro->delete();
    }
}
