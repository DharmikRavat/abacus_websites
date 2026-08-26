<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use App\Models\Score;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    /**
     * Display exam results.
     */

    
    public function index()
    {
        $scores = Score::count();
    
        $results = ExamResult::with([
            'student',
            'score',
            'declaredBy'
        ])
        ->latest('declared_at')
        ->paginate(10);
    
        return view('admin.exam-results.index', compact(
            'scores',
            'results'
        ));
    }
}