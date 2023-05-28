<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'verified'], ['except' => ['index', 'show']]);
    }
    
    public function index()
    {
        $userRoles = UserRole::with('user', 'role')->get();
        return response()->json($userRoles);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole = UserRole::create($validatedData);

        return response()->json($userRole, 201);
    }

    public function show(UserRole $userRole)
    {
        $userRole->load('user', 'role');
        return response()->json($userRole);
    }

    public function update(Request $request, UserRole $userRole)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userRole->update($validatedData);

        return response()->json($userRole);
    }

    public function destroy(UserRole $userRole)
    {
        $userRole->delete();

        return response()->json(null, 204);
    }
}
