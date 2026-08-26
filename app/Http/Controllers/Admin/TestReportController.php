<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestReport;
use App\Models\TestReportStudent;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class TestReportController extends Controller
{
    public function index()
    {
        $scores = Score::with('customer')
            ->latest()
            ->get();

        $reports = TestReport::with([
                'students.score.customer'
            ])
            ->latest()
            ->get();

        return view('admin.test-reports.index', compact(
            'scores',
            'reports'
        ));
    }

    /**
     * Store new test report
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_number' => 'required|string|max:100',
            'type' => 'required|in:Weekly,Monthly',
            'test' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'trainer' => 'nullable|string|max:255',
            'date' => 'required|date',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:scores,id',
        ]);

        DB::beginTransaction();

        try {

            $report = TestReport::create([
                'report_number' => $request->report_number,
                'type' => $request->type,
                'test' => $request->test,
                'level' => $request->level,
                'trainer' => $request->trainer,
                'report_date' => $request->date,
            ]);

            foreach ($request->students as $scoreId) {

                $score = Score::findOrFail($scoreId);

                $percentage = $score->total > 0
                    ? round(($score->correct / $score->total) * 100, 2)
                    : 0;

                if ($percentage >= 95) {
                    $remark = 'Outstanding';
                } elseif ($percentage >= 90) {
                    $remark = 'Excellent';
                } elseif ($percentage >= 85) {
                    $remark = 'Very Good';
                } elseif ($percentage >= 70) {
                    $remark = 'Good';
                } else {
                    $remark = 'Needs Improvement';
                }

                TestReport::create([
                    'test_report_id' => $report->id,
                    'score_id' => $score->id,
                    'percentage' => $percentage,
                    'result' => $percentage >= 70
                        ? 'Green'
                        : 'Red',
                    'remark' => $remark,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Test report created successfully.',
                'report' => $report->load('students.score.customer'),
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update test report
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'report_number' => 'required|string|max:100',
            'type' => 'required|in:Weekly,Monthly',
            'test' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'trainer' => 'nullable|string|max:255',
            'date' => 'required|date',
            'students' => 'required|array|min:1',
            'students.*' => 'exists:scores,id',
        ]);

        DB::beginTransaction();

        try {

            $report = TestReport::findOrFail($id);

            $report->update([
                'report_number' => $request->report_number,
                'type' => $request->type,
                'test' => $request->test,
                'level' => $request->level,
                'trainer' => $request->trainer,
                'report_date' => $request->date,
            ]);

            // Remove old students
            TestReport::where(
                'test_report_id',
                $report->id
            )->delete();

            // Add updated students
            foreach ($request->students as $scoreId) {

                $score = Score::findOrFail($scoreId);

                $percentage = $score->total > 0
                    ? round(($score->correct / $score->total) * 100, 2)
                    : 0;

                if ($percentage >= 95) {
                    $remark = 'Outstanding';
                } elseif ($percentage >= 90) {
                    $remark = 'Excellent';
                } elseif ($percentage >= 85) {
                    $remark = 'Very Good';
                } elseif ($percentage >= 70) {
                    $remark = 'Good';
                } else {
                    $remark = 'Needs Improvement';
                }

                TestReport::create([
                    'test_report_id' => $report->id,
                    'score_id' => $score->id,
                    'percentage' => $percentage,
                    'result' => $percentage >= 70
                        ? 'Green'
                        : 'Red',
                    'remark' => $remark,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Test report updated successfully.',
                'report' => $report->load('students.score.customer'),
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete test report
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $report = TestReport::findOrFail($id);

TestReport::where(
                'test_report_id',
                $report->id
            )->delete();

            $report->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Test report deleted successfully.',
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}