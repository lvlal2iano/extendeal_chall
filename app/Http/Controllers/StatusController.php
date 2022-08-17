<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\StatusResource;

class StatusController extends Controller
{
    public function index(){
        return StatusResource::make([]);
    }
}
