<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function index()
    {
        // Ventas totales por mes (últimos 6 meses)
        $ventasMensuales = Order::selectRaw('MONTH(created_at) as mes, SUM(total) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // Convertir número de mes a nombre corto
        $mesesNombres = [];
        $valoresVentas = [];
        foreach ($ventasMensuales as $mes => $total) {
            $mesesNombres[] = date('M', mktime(0, 0, 0, $mes, 1));
            $valoresVentas[] = $total;
        }

        // Top 5 productos más vendidos
        $topProductos = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as cantidad'))
            ->groupBy('products.name')
            ->orderByDesc('cantidad')
            ->limit(5)
            ->get();

        $productosNombres = $topProductos->pluck('name');
        $productosCantidad = $topProductos->pluck('cantidad');

        // Tarjetas de resumen
        $ventasTotales = Order::sum('total');
        $ordenes = Order::count();
        $usuarios = DB::table('users')->count();
        $productos = Product::count();

        // Órdenes recientes
        $ordenesRecientes = Order::with('user') // Asumiendo relación user() en el modelo Order
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'user_id', 'total', 'status', 'created_at']);

        return view('admin.dashboard', compact(
            'ventasTotales',
            'ordenes',
            'usuarios',
            'productos',
            'mesesNombres',
            'valoresVentas',
            'productosNombres',
            'productosCantidad',
            'ordenesRecientes'
        ));
    }
}
