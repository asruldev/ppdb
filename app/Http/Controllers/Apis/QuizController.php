<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();

        return response()->json([
            'status' => true,
            'data' => $quizzes,
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $quiz,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'quiz_time' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $quiz = Quiz::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Quiz created successfully',
            'data' => $quiz,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'quiz_time' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Quiz updated successfully',
            'data' => $quiz,
        ]);
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quiz deleted successfully',
        ]);
    }
}
