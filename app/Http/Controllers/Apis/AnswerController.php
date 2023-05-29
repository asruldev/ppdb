<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::all();

        return response()->json([
            'status' => true,
            'data' => $answers,
        ]);
    }

    public function show($id)
    {
        $answer = Answer::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $answer,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'user_id' => 'required',
            'answer_text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $answer = Answer::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Answer created successfully',
            'data' => $answer,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'user_id' => 'required',
            'answer_text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $answer = Answer::findOrFail($id);
        $answer->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Answer updated successfully',
            'data' => $answer,
        ]);
    }

    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Answer deleted successfully',
        ]);
    }
}