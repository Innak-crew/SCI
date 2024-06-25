<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoiceDownload(string $encodeID){
        set_time_limit(200);

        $decodeID = base64_decode($encodeID);
        $order = Orders::find($decodeID);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $invoice = $order->invoice()->first();
        $customer = $order->customer()->first();
        $orderItems = $order->orderItems;

        $processedOrderItems = $orderItems->map(function ($item) {
            return [
                'category_name' => $item->catagories->name,
                'design_name' => $item->design->name,
                'quantity' => rtrim(rtrim(number_format($item->quantity, 2), '0'), '.'),
                'unit' => $item->design->unit->name,
                'rate_per' => format_inr(rtrim(rtrim(number_format($item->rate_per, 2), '0'), '.'), ),
                'discount_amount' => format_inr(rtrim(rtrim(number_format($item->discount_amount, 2), '0'), '.'), 1),
                'discount_percentage' => rtrim(rtrim(number_format($item->discount_percentage, 2), '0'), '.'),
                'total' => format_inr(rtrim(rtrim(number_format($item->total, 2), '0'), '.'), 1),
            ];
        });

        $totalAmount = $order->invoice()->first()->total_amount;
        $formattedAmount = str_replace(",", "", number_format($totalAmount));
        $amountInWords = inrConvertNumberToWords((int)$formattedAmount);

        $logoPath = public_path('images/logo/logo-1.png');
        $logoData = base64_encode(file_get_contents($logoPath));

        $signaturePath = public_path('images/sign/invoice-sign-1.png');
        $signatureData = base64_encode(file_get_contents($signaturePath));

        $data = [
            'createdby_name' => $order->user()->first()->name,
            'order' => $order,
            'created_date' => Carbon::parse($invoice->created_date)->format('jS M Y'),
            'invoice_number' => $invoice->invoice_number,
            'due_date' => Carbon::parse($invoice->due_date)->format('jS M Y'),
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'customer_address' => $customer->address,
            'orderItems' => $processedOrderItems,
            'discount_amount' => format_inr(number_format($invoice->discount_amount)),
            'total_amount'=> format_inr(number_format($invoice->total_amount)),
            'terms_and_conditions' => nl2br(e($invoice->terms_and_conditions)),
            'amountInWords' => $amountInWords,
            'logoData' => $logoData,
            'signatureData' => $signatureData,
        ];

        $pdf = Pdf::loadView('admin.invoice.template', $data);
        return $pdf->download('invoice-'.$invoice->invoice_number. '.pdf');
        // return $pdf->stream(); 
        // return view('admin.invoice.template', $data);
    }

    public function vendorInvoiceDownload(string $encodeID){
        set_time_limit(300);

        $decodeID = base64_decode($encodeID);
        $order = Orders::find($decodeID);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $invoice = $order->invoice()->first();
        $orderItems = $order->orderItems;

        $processedOrderItems = $orderItems->map(function ($item) {
            $imagePath = public_path($item->design->image_url);
            $imageData = file_exists($imagePath) ? base64_encode(file_get_contents($imagePath)) : null;
            return [
                'category_name' => $item->catagories->name,
                'design_name' => $item->design->name,
                'quantity' => rtrim(rtrim(number_format($item->quantity, 2), '0'), '.'),
                'unit' => $item->design->unit->name,
                'imageData' => $imageData ,
            ];
        });

        $logoPath = public_path('images/logo/logo-1.png');
        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    
        $signaturePath = public_path('images/sign/invoice-sign-1.png');
        $signatureData = file_exists($signaturePath) ? base64_encode(file_get_contents($signaturePath)) : null;
    
        $data = [
            'order' => $order,
            'createdby_name' => $order->user()->first()->name,
            'created_date' => Carbon::parse($invoice->created_date)->format('jS M Y'),
            'invoice_number' => $invoice->invoice_number,
            'orderItems' => $processedOrderItems,
            'logoData' => $logoData,
            'signatureData' => $signatureData,
        ];

        $pdf = Pdf::loadView('admin.invoice.vendor', $data);
        return $pdf->download('vendor-'.$invoice->invoice_number. '.pdf');
        // return $pdf->stream(); 
        // return view('admin.invoice.vendor', $data);
    }
}
