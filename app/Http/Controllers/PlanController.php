<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    //
    public function index()
    {
        // Traer solo planes donde is_active = 0 (es decir, habilitados para mostrar)
        $planes = Plan::where('is_active', 0)->get();
        return view('subscription.plans', compact('planes'));
    }
}
