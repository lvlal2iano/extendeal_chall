<?php

namespace Tests\Feature\Cuadros;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Cuadro;
use App\Models\User;
use Tests\TestCase;

class StoreUpdateDeleteCuadrosTest extends TestCase
{
    
    public $cuadro_id;
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
    public function crear_un_cuadro(){
        $data = [
            'autor' => 'Un Autor de prueba',
            'nombre' => 'Una Obra de prueba',
            'precio' => '100000000',
            'anio_creacion'	=> '1901-01-01',
            'alto' => '150',
            'ancho'	=> '150',
            'img_url' => 'http://UnaUrlDePrueba',
            'sala' => 5,
            'procedencia' => 'AR',
        ];

        $response = $this->postJson('/api/v1/cuadros', $data);

        putenv('CUADRO_ID='.(integer) json_decode($response->getContent())->data->atributos->id);

        $cuadro = Cuadro::find(getenv('CUADRO_ID'));
        
        $response
         ->assertStatus(201)
         ->assertExactJson([
            'data' => [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => 'Una Obra de prueba',
                    'author' => 'Un Autor de prueba',
                    'precio' => '100000000',
                    'anio_creacion' => '1901-01-01',
                    'alto' => '150',
                    'ancho' => '150',
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
    public function editar_un_cuadro(){
        $data = [
            'autor' => 'Un Autor de prueba Editado',
            'nombre' => 'Una Obra de prueba Editado',
            'precio' => '90000000',
            'anio_creacion'	=> '1903-01-01',
            'alto' => '155',
            'ancho'	=> '155',
            'img_url' => 'http://UnaUrlDePruebaEditado',
            'sala' => 4,
            'procedencia' => 'BR',
        ];
        
        $response = $this->putJson('/api/v1/cuadros/'.getenv('CUADRO_ID'), $data);

        $cuadro = Cuadro::find(getenv('CUADRO_ID'));

        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => [
                'tipo' => 'Cuadro',
                'atributos' => [
                    'id' => (string) $cuadro->id(),
                    'nombre' => 'Una Obra de prueba Editado',
                    'author' => 'Un Autor de prueba Editado',
                    'precio' => '90000000',
                    'anio_creacion' => '1903-01-01',
                    'alto' => '155',
                    'ancho' => '155',
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
    public function eliminar_un_cuadro(){
        
        $response = $this->deleteJson('/api/v1/cuadros/'.getenv('CUADRO_ID'));
        $response
         ->assertStatus(200)
         ->assertExactJson([
            'data' => '',
            'status' => 'success',
            'code' => '200',
            'error' => ''
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
