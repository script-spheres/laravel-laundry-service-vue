<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RoleService $roleService)
    {
        $roles = $roleService->getRoles();

        return Inertia::render('Role/RoleIndex', [
            'roles' => RoleResource::collection($roles),
            'filters' => $request->get('filter'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PermissionService $permissionService)
    {
        return Inertia::render('Role/RoleForm', [
            'permissionsOptions' => $permissionService->getPermissionsOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, RoleService $roleService)
    {
        $roleService->create($request);

        return redirect()->route('roles.index')->with(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Inertia::render('Role/RoleShow', [
            'role' => RoleResource::make($role)->resolve(),
            'permissions' => Inertia::defer(fn () => Permission::all()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role, PermissionService $permissionService)
    {
        return Inertia::render('Role/RoleForm', [
            'role' => RoleResource::make($role)->resolve(),
            'permissionsOptions' => $permissionService->getPermissionsOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role, RoleService $roleService)
    {
        $roleService->update($role, $request);

        return redirect()->route('roles.index')->with(['message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, RoleService $roleService)
    {
        $roleService->delete($role);

        return redirect()->route('roles.index')->with(['message' => 'Deleted successfully']);
    }
}
