<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::latest()->get();
        return inertia('FrontOffice/Visitor', [
            'menu' => 'Visitor Book',
            'sidebar' => 'Front Office',
            'visitors' => $visitors,
            'visitor' => new Visitor(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Visitor::rules());
        try {
            Visitor::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Visitor created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Visitor $visitor)
    {
        $visitors = Visitor::latest()->get();
        return inertia('FrontOffice/Visitor', [
            'menu' => 'Visitor Book',
            'sidebar' => 'Front Office',
            'visitors' => $visitors,
            'visitor' => $visitor,
        ]);
    }
    public function update(Request $request, Visitor $visitor)
    {
        $data = $request->validate(Visitor::rules($visitor->id));
        try {
            $visitor->update($data);
            // event(new CourseEvent());
            return redirect()->route('visitor.index')->with('success', 'Visitor updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('visitor.index')->with('error', $th->getMessage());
        }
    }
    public function delete($id)
    {
        Visitor::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('visitor.index')->with('success', 'Visitor deleted successfully');
    }
}
