<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class OrderInvoiceController extends Controller
{
    /**
     * Generate a thermal printer invoice PDF.
     */
    public function index(Request $request, Order $order)
    {
        // Load related customer data
        $order->load('customer');

        // Set custom dimensions for thermal printer paper (80mm width)
        $customPaper = []; // 80mm width, dynamic height

        // Generate the PDF with the custom paper size
        return Pdf::view('pdfs.order-invoice', ['order' => $order])
            ->paperSize(226.77, 841.89) // Apply custom size
            ->name('invoice.pdf');
    }
}
