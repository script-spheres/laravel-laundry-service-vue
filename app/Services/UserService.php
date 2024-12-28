<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserService
{
    /**
     * Get paginated users with filters and sorting.
     */
    public function getUsers()
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::callback('role', function ($query, $value) {
                    $query->whereHas('roles', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('permission', function ($query, $value) {
                    $query->whereHas('permissions', function ($query) use ($value) {
                        $query->where('name', 'like', "%{$value}%");
                    });
                }),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new user and optionally assign roles.
     */
    public function create(StoreUserRequest $request): User
    {
        $attributes = $request->validated();
        $user = User::create($attributes);

        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        return $user;
    }

    /**
     * Update an existing user and optionally update roles.
     */
    public function update(User $user, UpdateUserRequest $request): User
    {
        $attributes = $request->validated();
        $user->update($attributes);

        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        return $user;
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    /**
     * Assign a role to a user.
     */
    public function assignRole(User $user, string $roleName): void
    {
        $user->assignRole($roleName);
    }

    /**
     * Remove a role from a user.
     */
    public function removeRole(User $user, string $roleName): void
    {
        $user->removeRole($roleName);
    }

    /**
     * Assign a permission to a user.
     */
    public function givePermission(User $user, string $permissionName): void
    {
        $user->givePermissionTo($permissionName);
    }

    /**
     * Remove a permission from a user.
     */
    public function revokePermission(User $user, string $permissionName): void
    {
        $user->revokePermissionTo($permissionName);
    }
}
