<?php

namespace App\Http\Controllers;

use App\Models\AdmissionSection;
use Illuminate\Http\Request;

class AdmissionSectionController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);
        $position = 1;

        $section = AdmissionSection::orderByDesc('position')->first();
        if ($section) {
            $position = $section->position;
        }

        $data['position'] = $position + 1;

        AdmissionSection::create($data);
        return redirect()->back()->with('success', "New section saved.");
    }

    public function destroy($id)
    {
        AdmissionSection::find($id)->delete();

        return redirect()->back()->with('success', 'Selected section have been removed');
    }

    public function update(Request $request, $id){
         $data = $request->validate([
            'name' => 'required'
        ]);
        $section=AdmissionSection::find($id)->update($data);

        return redirect()->back()->with('success',"Selected section updated");
    }

    public function status($id){
        $section=AdmissionSection::find($id);

        $section->update([
            'status'=>!$section->status
        ]);
        return response()->json([
            'success'=>true
        ]);
        // return redirect()->back()->with('success',"Status changed");
    }
}
