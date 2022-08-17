<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuadroRequest;
use App\Http\Requests\UpdateCuadroRequest;
use App\Http\Requests\FiltersCuadroRequest;
use App\Http\Resources\CuadroResource;
use App\Services\CuadroService;
use App\Models\Cuadro;

class CuadrosController extends Controller
{
    public $service;

    public function __construct(){
        $this->service = new CuadroService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FiltersCuadroRequest $request)
    {
        $per_page = $request->query('per_page')??10;
        $filters = $request->query('filters')??[];

        $cuadros = $this->service->find($filters, $per_page);
        return CuadroResource::collection($cuadros);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCuadroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCuadroRequest $request)
    {
        $cuadro = $this->service->store($request);
        return CuadroResource::make($cuadro);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuadro  $cuadro
     * @return \Illuminate\Http\Response
     */
    public function show(Cuadro $cuadro)
    {
        return CuadroResource::make($cuadro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuadro  $cuadro
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuadro $cuadro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCuadroRequest  $request
     * @param  \App\Models\Cuadro  $cuadro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCuadroRequest $request, Cuadro $cuadro)
    {
        $updated = $this->service->update($request, $cuadro);
        return CuadroResource::make($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuadro  $cuadro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuadro $cuadro)
    {
        return $this->service->delete($cuadro) ?
        response()->json([
            'data' => '',
            'status' => 'success',
            'code' => '200',
            'error' => ''
        ]):
        response()->json([
            'data' => '',
            'status' => 'error',
            'code' => '422',
            'error' => 'No se ha podido eliminar el recurso'
        ]);
    }
}
