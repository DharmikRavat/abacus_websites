<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Show edit page (ONLY ONE RECORD)
     */
    public function index()
    {
        $statistics = Statistics::first(); // only one row

        return view('admin.statistics.index', compact('statistics'));
    }

    /**
     * Store or update the single record
     */
    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Update single record
     */
    public function update(Request $request, $id = null)
    {
        return $this->save($request);
    }

    /**
     * Shared save method (UPSERT logic)
     */
    private function save(Request $request)
    {
        $request->validate([
            'course_count'    => 'required|integer|min:0',
            'teachers_count'  => 'required|integer|min:0',
            'members_count'   => 'required|integer|min:0',
            'countries_count' => 'required|integer|min:0',
           
        ]);

        // Always take first row or create new one
        $statistics = Statistics::first();

        if (!$statistics) {
            $statistics = new Statistics();
        }

        $statistics->course_count    = $request->course_count;
        $statistics->teachers_count  = $request->teachers_count;
        $statistics->members_count   = $request->members_count;
        $statistics->countries_count = $request->countries_count;
      

        $statistics->save();

        return response()->json([
            'success' => true,
            'message' => 'Statistics saved successfully',
            'data'    => $statistics,
        ]);
    }
}