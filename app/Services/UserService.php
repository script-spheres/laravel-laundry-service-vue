<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
    /**
     * Get paginated users with filters and sorting.
     */
    public function getUsers()
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters(['id', 'name', 'email'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new user.
     */
    public function create(StoreUserRequest $request): User
    {
        $attributes = $request->validated();
        return User::create($attributes);
    }

    /**
     * Update an existing user.
     */
    public function update(User $user, UpdateUserRequest $request): User
    {
        $attributes = $request->validated();
        $user->update($attributes);
        return $user;
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): void
    {
        $user->delete();
    }
}
