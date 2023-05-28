<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified'], ['except' => ['index', 'show']]);
    }
    
    public function index()
    {
        $roles = Role::with('users')->get();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'nullable',
        ]);

        $role = Role::create($validatedData);

        return response()->json($role, 201);
    }

    public function show(Role $role)
    {
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'description' => 'nullable',
        ]);

        $role->update($validatedData);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }
}