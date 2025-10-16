<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminController extends Controller
{
    //
    public function index(){
        // Total de ventas (sumatoria de la columna 'total' de la tabla orders)
        $ventasTotales = Order::sum('total');

        // Cantidad total de órdenes
        $ordenes = Order::count();

        // Total de usuarios registrados
        $usuarios = User::count();

        // Total de productos activos
        $productos = Product::count();

        // Enviar datos a la vista
        return view('admin.dashboard', compact(
            'ventasTotales',
            'ordenes',
            'usuarios',
            'productos'
        ));
    }
}
