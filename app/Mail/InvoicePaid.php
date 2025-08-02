<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\InvoiceStore;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePaid extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoice;

    public function __construct(Order $order, InvoiceStore $invoice)
    {
        $order->load('userAddress');
        $this->order = $order;
        $this->invoice = $invoice;
    }

    public function build()
    {
        // Generar PDF desde la vista
    $pdf = Pdf::loadView('invoices.storepdf', [
        'invoice' => $this->invoice,
        'order'   => $this->order,
    ])->output();

    return $this->subject('Tu factura y orden de compra')
                ->markdown('emails.invoices_store')
                ->attachData($pdf, 'factura-' . $this->invoice->invoice_number . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
