<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 🔹 AJAX request → return questions JSON
        if ($request->ajax()) {

            $questions = Question::latest()->get()->map(function ($q) {
                return [
                    'id'               => $q->id,
                    'question'         => $q->question,
                    'question_type_id' => $q->question_type_id,
                    'question_type'    => $q->questionType->name ?? '-',
                    'options'          => $q->options,
                    'correct_option'   => $q->correct_option,
                    'exam_level'       => $q->exam_level,
                    'difficulty'       => $q->difficulty,
                ];
            });

            return response()->json([
                'success'   => true,
                'questions' => $questions,
            ]);
        }

        // 🔹 Normal page load
        $questionTypes = QuestionType::where('is_active', 1)->get();

        $levels = DB::table('exam_levels')
            ->where('is_active', 1)
            ->select('level')
            ->distinct()
            ->orderBy('level')
            ->get();

        return view('admin.questions.index', compact('questionTypes', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question_type_id'            => 'required|exists:question_types,id',
            'exam_level'                  => 'required',
            'difficulty'                  => 'required|in:easy,medium,hard',
            'schedule_test_type'          => 'nullable|string',

            'questions'                   => 'required|array|min:1',

            'questions.*.question'        => 'required|string',
            'questions.*.options'         => 'required|array|size:4',
            'questions.*.options.A'       => 'required|string',
            'questions.*.options.B'       => 'required|string',
            'questions.*.options.C'       => 'required|string',
            'questions.*.options.D'       => 'required|string',
            'questions.*.correct_option'  => 'required|in:A,B,C,D',
        ]);

        foreach ($request->questions as $q) {

            Question::create([
                'question'         => $q['question'],
                'question_type_id' => $request->question_type_id,
                'exam_level'       => $request->exam_level,
                'difficulty'       => $request->difficulty,
                'options'          => $q['options'],
                'correct_option'   => $q['correct_option'],
                'schedule_test_type' => $request->schedule_test_type
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Questions added successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);

        return response()->json([
            'success'  => true,
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'question'          => 'required|string',
            'question_type_id'  => 'required|string',
            'options'           => 'required|array|min:2',
            'correct_option'    => 'required|string',
            'exam_level'        => 'nullable|string',
            'difficulty'        => 'nullable|string',
            
        ]);

        $question = Question::findOrFail($id);

        $question->update([
            'question'          => $request->question,
            'question_type_id'  => $request->question_type_id,
            'options'           => $request->options,
            'correct_option'    => $request->correct_option,
            'exam_level'        => $request->exam_level,
            'difficulty'        => $request->difficulty,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Question updated successfully',
            'question' => $question,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question deleted successfully',
        ]);
    }
}