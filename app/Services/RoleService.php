<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * Get a list of roles with optional filtering.
     */
    public function getRoles($filters = []): LengthAwarePaginator
    {
        return Role::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })
            ->latest()->paginate();
    }

    /**
     * Create a new role.
     */
    public function create(Request $request)
    {
        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * Update an existing role.
     */
    public function update(Role $role, Request $request): Role
    {
        $role->update([
            'name' => $request->input('name'),
        ]);

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * Delete a role.
     */
    public function delete(Role $role): ?bool
    {
        return $role->delete();
    }
}
