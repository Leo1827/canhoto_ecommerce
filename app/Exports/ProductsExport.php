<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with(['category', 'winery'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Slug',
            'Categoria',
            'Vinícola',
            'Preço',
            'Estoque',
            'Criado em',
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->slug,
            $product->category->name ?? '—',
            $product->winery->name ?? '—',
            $product->price,
            $product->stock,
            $product->created_at->format('Y-m-d'),
        ];
    }
}
