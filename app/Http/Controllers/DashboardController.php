<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        // $this->authorize('admin_general_dashboard');
        return view('dashboard.index');
    }
}
