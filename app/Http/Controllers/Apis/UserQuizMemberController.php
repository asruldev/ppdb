<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\UserQuizMember;
use Illuminate\Http\Request;

class UserQuizMemberController extends Controller
{
    public function index()
    {
        $userQuizMembers = UserQuizMember::all();
        return response()->json($userQuizMembers);
    }

    public function store(Request $request)
    {
        $userQuizMember = UserQuizMember::create($request->all());
        return response()->json($userQuizMember, 201);
    }

    public function show(UserQuizMember $userQuizMember)
    {
        return response()->json($userQuizMember);
    }

    public function update(Request $request, UserQuizMember $userQuizMember)
    {
        $userQuizMember->update($request->all());
        return response()->json($userQuizMember);
    }

    public function destroy(UserQuizMember $userQuizMember)
    {
        $userQuizMember->delete();
        return response()->json(null, 204);
    }
}
