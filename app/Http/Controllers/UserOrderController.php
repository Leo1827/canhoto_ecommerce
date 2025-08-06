<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InvoiceStore;

class UserOrderController extends Controller
{
    use AuthorizesRequests;
    //
    public function index(Request $request)
    {
        $query = Order::with(['invoice', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Si se buscó por número de factura
        if ($request->filled('invoice')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->invoice . '%');
            });

            $orders = $query->get(); // Mostrar todos si se está buscando
        } else {
            $orders = $query->paginate(6); // Solo paginar si no hay búsqueda
        }

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // Asegúrate de tener una policy

        // Asegúrate de cargar las relaciones necesarias
        $order->load(['items.product', 'invoice', 'statusHistories', 'address']);

        return view('orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('invoice', 'userAddress');

        if (!$order->invoice) {
            abort(404, 'Fatura não encontrada.');
        }

        // Renderizar la vista en PDF (igual que en el Mailable)
        $pdf = Pdf::loadView('invoices.storepdf', [
            'invoice' => $order->invoice,
            'order'   => $order,
        ]);

        return $pdf->download('factura-' . $order->invoice->invoice_number . '.pdf');
    }

    
}
