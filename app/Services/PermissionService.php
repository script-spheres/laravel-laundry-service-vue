<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * Get grouped permissions with labels.
     *
     * @return array
     */
    public function getPermissionsOptions(): array
    {
        $permissions = Permission::all();

        // Group permissions dynamically by their resource prefix
        return $permissions
            ->groupBy(function ($permission) {
                return explode('.', $permission->name, 2)[0] ?? $permission->name;
            })
            ->map(function ($permissions, $resource) {
                return [
                    'group' => $resource,
                    'label' => ucfirst(str_replace('-', ' ', $resource)),
                    'permissions' => $permissions->map(function ($permission) {
                        return [
                            'name' => $permission->name,
                            'label' => ucfirst(str_replace('.', ' ', $permission->name)),
                        ];
                    })->values()->all(),
                ];
            })
            ->values()
            ->all();
    }
}
