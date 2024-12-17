<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;

class RoleService
{
    /**
     * Get a list of roles with optional filtering.
     */
    public function getRoles($filters = [])
    {
        return SpatieRole::query()
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
        $role = SpatieRole::create([
            'name' => $request->input('name'),
        ]);

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * Update an existing role.
     */
    public function update(SpatieRole $role, Request $request)
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
    public function delete(SpatieRole $role)
    {
        return $role->delete();
    }
}
