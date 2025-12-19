<?php

namespace App\Http\Controllers;

use App\Models\PostalDispatch;
use Illuminate\Http\Request;

class PostalDispatchController extends Controller
{
    public function index()
    {
        $postalDispatchs = PostalDispatch::latest()->get();
        return inertia('FrontOffice/PostalDispatch', [
            'menu' => 'Postal Dispatch',
            'sidebar' => 'Front Office',
            'postalDispatchs' => $postalDispatchs,
            'postalDispatch' => new PostalDispatch(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(PostalDispatch::rules());
        try {
            PostalDispatch::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Postal Dispatch created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(PostalDispatch $postalDispatch)
    {
        $postalDispatchs = PostalDispatch::latest()->get();
        return inertia('FrontOffice/PostalDispatch', [
            'menu' => 'Postal Dispatch',
            'sidebar' => 'Front Office',
            'postalDispatchs' => $postalDispatchs,
            'postalDispatch' => $postalDispatch,
        ]);
    }
    public function update(Request $request, PostalDispatch $postalDispatch)
    {
        $data = $request->validate(PostalDispatch::rules($postalDispatch->id));
        try {
            $postalDispatch->update($data);
            // event(new CourseEvent());
            return redirect()->route('postalDispatch.index')->with('success', 'Postal Dispatch updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('postalDispatch.index')->with('error', $th->getMessage());
        }
    }
    public function delete($id)
    {
        PostalDispatch::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('postalDispatch.index')->with('success', 'Postal Dispatch deleted successfully');
    }
}
