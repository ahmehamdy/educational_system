<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(){

        $levels = Level::all();
        $response = [
            'status' => 200,
            'data' => $levels,
            'message' => 'Get All levels Successfully'
        ];

        return response()->json($response);

    }
}
