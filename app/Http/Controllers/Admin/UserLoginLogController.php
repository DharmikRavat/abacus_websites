<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLoginLog;
use Illuminate\Support\Facades\DB;

class UserLoginLogController extends Controller
{
    /**
     * Display login logs.
     */
    public function index()
    {
        $stats = [
            'total' => UserLoginLog::count(),
        
            'platforms' => UserLoginLog::select('login_from', DB::raw('count(*) as total'))
                ->groupBy('login_from')
                ->pluck('total', 'login_from'),
        
            'browsers' => UserLoginLog::select('browser', DB::raw('count(*) as total'))
                ->groupBy('browser')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
        
            'devices' => UserLoginLog::select('device_type', DB::raw('count(*) as total'))
                ->groupBy('device_type')
                ->get(),
        ];
        $logs = UserLoginLog::with('user')
            ->latest('login_at')
            ->paginate(25);

        return view('admin.activity-log.index', compact('logs','stats'));
    }

    /**
     * Display a single login log.
     */
    public function show(UserLoginLog $userLoginLog)
    {
        return view('admin.activity-log.show', [
            'log' => $userLoginLog->load('user')
        ]);
    }
}