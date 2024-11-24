<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CustomerService $customerService)
    {
        $customers = $customerService->getCustomers();

        return inertia('Admin/Customer/CustomerIndex', [
            'customers' => CustomerResource::collection($customers),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Customer/CustomerForm');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request, CustomerService $customerService)
    {
        $customerService->create($request);

        return redirect()->route('admin.customers.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return inertia('Admin/Customer/CustomerForm', [
            'customer' => CustomerResource::make($customer)->resolve()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return inertia('Admin/Customer/CustomerForm', [
            'customer' => CustomerResource::make($customer)->resolve()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer, CustomerService $customerService)
    {
        $customerService->update($customer, $request);

        return redirect()->route('admin.customers.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, CustomerService $customerService)
    {
        $customerService->delete($customer);

        return redirect()->route('admin.customers.index')->with(['message' => 'Deleted successfully']);
    }
}
