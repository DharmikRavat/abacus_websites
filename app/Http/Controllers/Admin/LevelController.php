<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamLevel;
use Illuminate\Http\Request;

class LevelController extends Controller
{public function index(Request $request)
    {
        $levels = ExamLevel::orderBy('difficulty')
            ->orderBy('level')
            ->get()
            ->groupBy('difficulty')
            ->map(function ($items) {
    
                return $items->map(function ($item) {
    
                    return [
                        'level' => (int) $item->level,
                        'is_active' => (int) $item->is_active,
                    ];
    
                });
    
            });
    
        // ✅ RETURN JSON FOR FETCH REQUEST
        if ($request->expectsJson()) {
    
            return response()->json($levels);
        }
    
        // ✅ NORMAL PAGE LOAD
        return view('admin.levels.index');
    }
    public function store(Request $request)
    {
        // Reset all levels first
        ExamLevel::query()->update(['is_active' => false]);
    
        if ($request->has('levels')) {
            foreach ($request->levels as $difficulty => $levels) {
                foreach ($levels as $level => $value) {
                    ExamLevel::updateOrCreate(
                        [
                            'difficulty' => $difficulty,
                            'level'      => $level,
                        ],
                        [
                            'is_active' => true
                        ]
                    );
                }
            }
        }
    
        return response()->json([
            'message' => 'Exam levels updated successfully'
        ]);
    }
    
}
