<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizResult;
use App\Models\Answer;

class QuizResultController extends Controller
{
    public function index()
    {
        $quizResults = QuizResult::all();

        return response()->json([
            'status' => true,
            'data' => $quizResults,
        ]);
    }

    public function show($id)
    {
        $quizResult = QuizResult::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $quizResult,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'nullable|numeric',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);

        $quizResult = QuizResult::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Test result created successfully',
            'data' => $quizResult,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'exists:users,id',
            'test_id' => 'exists:quizzes,id',
            'score' => 'numeric',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
        ]);

        $quizResult = QuizResult::findOrFail($id);
        $quizResult->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Test result updated successfully',
            'data' => $quizResult,
        ]);
    }

    public function destroy($id)
    {
        $quizResult = QuizResult::findOrFail($id);
        $quizResult->delete();

        return response()->json([
            'status' => true,
            'message' => 'Test result deleted successfully',
        ]);
    }

    // Route::post('/quiz-user-histories/{historyId}/save-answers', 'QuizUserHistoryController@saveUserAnswers');
    public function saveUserAnswers(Request $request, $historyId)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.option_id' => 'required|exists:options,id',
        ]);

        $quizUserHistory = QuizUserHistory::findOrFail($historyId);
        $answers = [];

        foreach ($request->answers as $answerData) {
            $answer = new Answer([
                'question_id' => $answerData['question_id'],
                'option_id' => $answerData['option_id'],
            ]);

            $answers[] = $answer;
        }

        $quizUserHistory->answers()->saveMany($answers);

        return response()->json([
            'status' => true,
            'message' => 'User answers saved successfully',
        ]);
    }

    public function getUserAnswers($historyId)
    {
        $quizUserHistory = QuizResult::findOrFail($historyId);
        $answers = $quizUserHistory->answers;

        return response()->json([
            'status' => true,
            'data' => $answers,
        ]);
    }
}