<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceStore;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    //
    public function index()
    {
        $invoices = InvoiceStore::with('order', 'user')->latest()->get();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(InvoiceStore $invoice)
    {
        // Cargamos la orden y todas sus relaciones de una vez
        $invoice->load([
            'order.items.product',
            'order.statusHistories',
            'order.userAddress'
        ]);

        return view('admin.invoices.show', compact('invoice'));
    }

    public function downloadInvoiceAdmin(Order $order)
    {
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

    public function destroy(InvoiceStore $invoice)
    {
        // Traemos la orden asociada
        $order = $invoice->order;
        // Primero borramos la factura
        $invoice->delete();
        // Luego borramos la orden (esto borrará en cascada los items e historiales)
        if ($order) {
            $order->delete();
        }

        return back()->with('success', 'Factura y orden asociada eliminadas');
    }

}
