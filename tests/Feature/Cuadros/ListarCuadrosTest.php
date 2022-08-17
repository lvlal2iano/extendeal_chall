<?php

namespace Tests\Feature\Cuadros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Cuadro;
use App\Models\User;
use Tests\TestCase;

class ListarCuadrosTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders(
            [
               'Accept' => 'application/json',
               'Content-Type' => 'application/json',
               'X-HTTP-USER-ID' => User::first()->id,
            ]
        );
    }

    /** @test */
    public function listar_un_cuadro()
    {
        $cuadro = Cuadro::first();

        $response = $this->getJson('/api/v1/cuadros/'.$cuadro->id());

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => $cuadro->nombre,
                    'author' => $cuadro->autor,
                    'precio' => $cuadro->precio,
                    'anio_creacion' => $cuadro->anio_creacion,
                    'alto' => $cuadro->alto,
                    'ancho' => $cuadro->ancho,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ],
            'meta' => ['count' => 1],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
         ]);
    }

    /** @test */
    public function listar_cuadros_paginando()
    {
        $response = $this->getJson('/api/v1/cuadros');

        $cuadros = Cuadro::paginate(10);

        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => $cuadro->nombre,
                    'author' => $cuadro->autor,
                    'precio' => $cuadro->precio,
                    'anio_creacion' => $cuadro->anio_creacion,
                    'alto' => $cuadro->alto,
                    'ancho' => $cuadro->ancho,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
         ]);
    }

    /** @test */
    public function listar_cuadros_paginando_pagina_2()
    {
        $response = $this->getJson('/api/v1/cuadros?page=2');

        $cuadros = Cuadro::offset(10)->take(10)->get();

        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => $cuadro->nombre,
                    'author' => $cuadro->autor,
                    'precio' => $cuadro->precio,
                    'anio_creacion' => $cuadro->anio_creacion,
                    'alto' => $cuadro->alto,
                    'ancho' => $cuadro->ancho,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
        ]);
    }

    /** @test */
    public function listar_cuadros_solo_atributo_nombre()
    {
        $response = $this->getJson('/api/v1/cuadros?fields=nombre');
 
        $cuadros = Cuadro::paginate(10);
 
        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'nombre' => $cuadro->nombre,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
        ]);

    }

    /** @test */
    public function listar_cuadros_solo_atributo_nombre_y_precio()
    {
        $response = $this->getJson('/api/v1/cuadros?fields=nombre,precio');
 
        $cuadros = Cuadro::paginate(10);
 
        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'nombre' => $cuadro->nombre,
                    'precio' => $cuadro->precio,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
        ]);

    }

    /** @test */
    public function listar_cuadros_per_page_random_1_a_25()
    {
        $per_page = rand(1,25);
        $response = $this->getJson('/api/v1/cuadros?per_page='.$per_page);
 
        $cuadros = Cuadro::paginate($per_page);
 
        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => $cuadro->nombre,
                    'author' => $cuadro->autor,
                    'precio' => $cuadro->precio,
                    'anio_creacion' => $cuadro->anio_creacion,
                    'alto' => $cuadro->alto,
                    'ancho' => $cuadro->ancho,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
        ]);

    }

    /** @test */
    public function listar_cuadros_con_filtros()
    {
        $autor = 'Rembrandt';
        $minPrecio = '140000000';
        $minCreacion = '1610-01-01';
        $filters = "filters[autor]=$autor&filters[minPrecio]=$minPrecio&filters[minCreacion]=$minCreacion";

        $response = $this->getJson('/api/v1/cuadros?'.$filters);
 
        $cuadros = Cuadro::Autor($autor)->minPrecio($minPrecio)->minCreacion($minCreacion)->paginate(10);
 
        $data = [];

        foreach($cuadros as $cuadro){
            $data[] = [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => $cuadro->nombre,
                    'author' => $cuadro->autor,
                    'precio' => $cuadro->precio,
                    'anio_creacion' => $cuadro->anio_creacion,
                    'alto' => $cuadro->alto,
                    'ancho' => $cuadro->ancho,
                ],
                'relaciones' => $this->relaciones($cuadro),
                'links' => $this->links($cuadro),
            ];
        }

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => $data,
            'meta' => ['count' => count($data)],
            'status' => 'success',
            'code' => '200',
            'errors' => ''
        ]);
    }


    public function relaciones(Cuadro $cuadro){
        return [
            'sala' => [
                'id' => $cuadro->sala->id,
                'nombre' => $cuadro->sala->nombre,
            ],
            'pais_procedencia' => [
                'codigo' => $cuadro->procedencia->code,
                'nombre' => $cuadro->procedencia->name,
            ],
        ];
    }

    public function links(Cuadro $cuadro){
        return [
            'self' => route('cuadros.show', [$cuadro->id()]),
            'img' => $cuadro->img_url
        ];
    }
}
