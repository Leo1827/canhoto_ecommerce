<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    //
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $log)
    {
        return view('admin.activity_logs.show', compact('log'));
    }
}
