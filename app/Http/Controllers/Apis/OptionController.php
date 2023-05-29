<?php
namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::all();

        return response()->json([
            'status' => true,
            'data' => $options,
        ]);
    }

    public function show($id)
    {
        $option = Option::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $option,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'option_text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $option = Option::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Option created successfully',
            'data' => $option,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required',
            'option_text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $option = Option::findOrFail($id);
        $option->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Option updated successfully',
            'data' => $option,
        ]);
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();

        return response()->json([
            'status' => true,
            'message' => 'Option deleted successfully',
        ]);
    }
}