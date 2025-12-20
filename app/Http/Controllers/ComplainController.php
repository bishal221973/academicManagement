<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function index()
    {
        $complains = Complain::latest()->get();
        return inertia('FrontOffice/Complain', [
            'menu' => 'Complain',
            'sidebar' => 'Front Office',
            'complains' => $complains,
            'complain' => new Complain(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Complain::rules());
        try {
            Complain::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Complain created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Complain $postalDispatch)
    {
        $complains = Complain::latest()->get();
        return inertia('FrontOffice/Complain', [
            'menu' => 'Complain',
            'sidebar' => 'Front Office',
            'complains' => $complains,
            'complain' => $postalDispatch,
        ]);
    }
    public function update(Request $request, Complain $postalDispatch)
    {
        $data = $request->validate(Complain::rules($postalDispatch->id));
        try {
            $postalDispatch->update($data);
            // event(new CourseEvent());
            return redirect()->route('postalDispatch.index')->with('success', 'Complain updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('postalDispatch.index')->with('error', $th->getMessage());
        }
    }
    public function delete($id)
    {
        Complain::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('postalDispatch.index')->with('success', 'Complain deleted successfully');
    }
}
