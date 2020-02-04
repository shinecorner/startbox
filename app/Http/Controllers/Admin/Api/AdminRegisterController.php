<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class AdminRegisterController extends ApiController
{
    public function __construct()
    {
    }

    public function register(Request $request)
    {
         //TODO
         return $this->respondData('Route reached at ' . url()->current(), ['body' => $request->all()]);
    }
}
