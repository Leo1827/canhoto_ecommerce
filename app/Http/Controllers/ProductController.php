<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }

    public function show($id)
    {
        // Simular productos
        $products = [
            'veridico-1900' => [
                'name' => 'Verídico 1900',
                'image' => 'product1.jpeg',
                'price' => 1200,
                'region' => 'Douro',
                'year' => 2023,
                'label' => 'Vino de Autor',
                'description' => 'Very Very Old Tawny Port · Douro - Portugal',
                'available' => true,
                'details' => [
                    'Embotellado' => '2023',
                    'Región' => 'Douro',
                    'Temperatura ideal' => '10-14°C',
                    'País' => 'Portugal',
                    'Grado alcohólico' => '20.5%',
                    'Capacidad' => '75cl',
                    'Casta' => 'Viñas Viejas',
                    'Certificado' => 'IVDP',
                ],
            ],
            'sassicaia-bolgheri' => [
                'name' => 'Sassicaia Bolgheri',
                'image' => 'product2.jpeg',
                'price' => 950,
                'region' => 'Toscana',
                'year' => 2015,
                'label' => 'Edición Limitada',
                'description' => 'Toscana 2015 · Tenuta San Guido',
                'available' => true,
                'details' => [
                    'Embotellado' => '2015',
                    'Región' => 'Toscana',
                    'Temperatura ideal' => '16-18°C',
                    'País' => 'Italia',
                    'Grado alcohólico' => '14%',
                    'Capacidad' => '75cl',
                    'Casta' => 'Cabernet Sauvignon',
                    'Certificado' => 'DOC',
                ],
            ],
        ];

        if (!array_key_exists($id, $products)) {
            abort(404);
        }

        $product = $products[$id];

        return view('products.show', compact('product'));
    }
}
