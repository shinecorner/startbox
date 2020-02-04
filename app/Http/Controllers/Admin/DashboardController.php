<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\MockRepository\ProcedureMock;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{

    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        return view('admin.dashboard');
    }

    public function domain_settings(Request $request)
    {
        //TODO APPLY ADMIN LEVEL SETTINGS
    }
}
