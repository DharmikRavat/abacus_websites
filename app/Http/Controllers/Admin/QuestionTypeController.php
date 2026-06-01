<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionTypes = QuestionType::latest()->get();

        return view('admin.question-types.index', compact('questionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|string|max:100|unique:question_types,type',
            'is_active'   => 'required|boolean',
        ]);

        $questionType = QuestionType::create([
            'name'        => $request->name,
            'description' => $request->description,
            'type'        => $request->type,
            'is_active'   => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Question type created successfully',
            'question_type' => $questionType,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $questionType = QuestionType::findOrFail($id);

        return response()->json([
            'success' => true,
            'question_type' => $questionType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $questionType = QuestionType::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|string|max:100|unique:question_types,type,' . $id,
            'is_active'   => 'required|boolean',
        ]);

        $questionType->update([
            'name'        => $request->name,
            'description' => $request->description,
            'type'        => $request->type,
            'is_active'   => $request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Question type updated successfully',
            'question_type' => $questionType,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $questionType = QuestionType::findOrFail($id);

        $questionType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question type deleted successfully',
        ]);
    }
}