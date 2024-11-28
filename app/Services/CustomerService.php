<?php

namespace App\Services;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerService
{
    /**
     * Get paginated customers with filters and sorting.
     */
    public function getCustomers()
    {
        return QueryBuilder::for(Customer::class)
            ->allowedFilters(['id', 'name'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new customer.
     */
    public function create(StoreCustomerRequest $request): Customer
    {
        $attributes = $request->validated();
        return Customer::create($attributes);
    }

    /**
     * Update an existing customer.
     */
    public function update(Customer $customer, UpdateCustomerRequest $request): Customer
    {
        $attributes = $request->validated();
        $customer->update($attributes);
        return $customer;
    }

    /**
     * Delete a customer.
     */
    public function delete(Customer $customer): void
    {
        $customer->delete();
    }
}
