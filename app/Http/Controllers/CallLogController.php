<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index()
    {
        $callLogs = CallLog::latest()->get();
        return inertia('FrontOffice/CallLog', [
            'menu' => 'Phone Call Log',
            'sidebar' => 'Front Office',
            'callLogs' => $callLogs,
            'callLog' => new CallLog(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(CallLog::rules());
        try {
            CallLog::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'CallLog created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(CallLog $callLog)
    {
        $callLogs = CallLog::latest()->get();
        return inertia('FrontOffice/CallLog', [
            'menu' => 'Phone Call Log',
            'sidebar' => 'Front Office',
            'callLogs' => $callLogs,
            'callLog' => $callLog,
        ]);
    }
    public function update(Request $request, CallLog $callLog)
    {
        $data = $request->validate(CallLog::rules($callLog->id));
        try {
            $callLog->update($data);
            // event(new CourseEvent());
            return redirect()->route('callLog.index')->with('success', 'CallLog updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('callLog.index')->with('error', $th->getMessage());
        }
    }
    public function delete($id)
    {
        CallLog::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('callLog.index')->with('success', 'CallLog deleted successfully');
    }
}
