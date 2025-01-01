<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PaymentService $paymentService)
    {
        $payments = $paymentService->getPayments();

        return Inertia::render('Payment/PaymentIndex', [
            'payments' => PaymentResource::collection($payments),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request, PaymentService $paymentService)
    {
        $paymentService->create($request);

        return redirect()->back()->with(['message' => 'Created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Payment/PaymentForm', [
            'customersOptions' => Customer::pluck('name', 'id')->all(),
            'ordersOptions' => Order::pluck('order_display_id', 'id')->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return Inertia::render('Payment/PaymentForm', [
            'payment' => PaymentResource::make($payment)->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return Inertia::render('Payment/PaymentForm', [
            'payment' => PaymentResource::make($payment)->resolve(),
            'customersOptions' => Customer::pluck('name', 'id')->all(),
            'ordersOptions' => Order::pluck('order_display_id', 'id')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment, PaymentService $paymentService)
    {
        $paymentService->update($payment, $request);

        return redirect()->route('payments.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment, PaymentService $paymentService)
    {
        $paymentService->delete($payment);

        return redirect()->route('payments.index')->with(['message' => 'Deleted successfully']);
    }
}
