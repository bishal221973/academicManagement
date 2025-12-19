<?php

namespace App\Http\Controllers;

use App\Models\PostalReceive;
use Illuminate\Http\Request;

class PostalReceiveController extends Controller
{
    public function index()
    {
        $postalReceives = PostalReceive::latest()->get();
        return inertia('FrontOffice/PostalReceive', [
            'menu' => 'Postal Receive',
            'sidebar' => 'Front Office',
            'postalReceives' => $postalReceives,
            'postalReceive' => new PostalReceive(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(PostalReceive::rules());
        try {
            PostalReceive::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Postal Receive created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(PostalReceive $postalReceive)
    {
        $postalReceives = PostalReceive::latest()->get();
        return inertia('FrontOffice/PostalReceive', [
            'menu' => 'Postal Receive',
            'sidebar' => 'Front Office',
            'postalReceives' => $postalReceives,
            'postalReceive' => $postalReceive,
        ]);
    }
    public function update(Request $request, PostalReceive $postalReceive)
    {
        $data = $request->validate(PostalReceive::rules($postalReceive->id));
        try {
            $postalReceive->update($data);
            // event(new CourseEvent());
            return redirect()->route('postalReceive.index')->with('success', 'Postal Receive updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('postalReceive.index')->with('error', $th->getMessage());
        }
    }
    public function delete($id)
    {
        PostalReceive::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('postalReceive.index')->with('success', 'Postal Receive deleted successfully');
    }
}
