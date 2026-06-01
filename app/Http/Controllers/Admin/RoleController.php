<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();
        $permissions = Permission::all();
        return view('admin.setting.role', compact('roles','permissions'));
    }
    public function store(Request $request)

    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission_ids' => 'nullable|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'is_active' => $request->is_active ?? 1
        ]);

        // Attach permissions
        if ($request->has('permission_ids')) {
            $role->permissions()->sync($request->permission_ids);
        }

        return response()->json(['success' => true, 'role' => $role]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permission_ids' => 'nullable|array'
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'is_active' => $request->is_active ?? 1
        ]);

        // Sync permissions (add/remove automatically)
        if ($request->has('permission_ids')) {
            $role->permissions()->sync($request->permission_ids);
        } else {
            $role->permissions()->sync([]); // remove all if none selected
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Role::destroy($id);
        return response()->json(['success' => true]);
    }
}
