<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();

        return response()->json([
            'status' => true,
            'data' => $questions,
        ]);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $question,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required',
            'question_text' => 'required',
            'question_type' => 'required',
            'point' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $question = Question::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Question created successfully',
            'data' => $question,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required',
            'question_text' => 'required',
            'question_type' => 'required',
            'point' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $question = Question::findOrFail($id);
        $question->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Question updated successfully',
            'data' => $question,
        ]);
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully',
        ]);
    }
}
