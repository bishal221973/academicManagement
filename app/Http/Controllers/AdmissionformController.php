<?php

namespace App\Http\Controllers;

use App\Models\AdmissionField;
use App\Models\AdmissionSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionformController extends Controller
{
    public function index()
    {
        $admissionFields = AdmissionField::with('section')
            ->where('status', 1) // admission_fields.status = 1
            ->whereHas('section', function ($query) {
                $query->where('status', 1); // admission_sections.status = 1
            })
            ->orderByRaw('CAST(position AS UNSIGNED) ASC') // admission_fields.position
            ->get()
            ->groupBy(function ($field) {
                return $field->section->name; // group by section name
            });

        // Optional: Sort groups by section position
        $admissionFields = $admissionFields->sortBy(function ($group, $key) {
            // Each group has items with the same section, so we can use the first one
            return $group->first()->section->position;
        });
        $sections=AdmissionSection::orderByRaw('CAST(position AS UNSIGNED) ASC')->get();
            $fields = AdmissionField::with('section')
            ->where('status', 1) // admission_fields.status = 1
            ->whereHas('section', function ($query) {
                $query->where('status', 1); // admission_sections.status = 1
            })
            ->orderByRaw('CAST(position AS UNSIGNED) ASC') // admission_fields.position
            ->get();
            
        return Inertia::render("Student/AdmissionForm", [
            'admissionFields' => $admissionFields,
            'sections'=>$sections,
            'fields1'=>$fields,
            'sidebar' => 'Students',
            'menu' => 'AdmitionForm',
        ]);
    }

    public function resize($id)
    {
        $field = AdmissionField::findOrFail($id);

        // Define the cycle of col-span values
        $colSpans = [3, 4, 5, 6, 12, 1, 2];

        // Get current col-span number from size field, e.g. "col-span-3"
        $currentSpan = intval(str_replace('col-span-', '', $field->size ?? '3'));

        // Find next span in the cycle
        $currentIndex = array_search($currentSpan, $colSpans);
        $nextIndex = ($currentIndex + 1) % count($colSpans);

        $field->size = 'col-span-' . $colSpans[$nextIndex];

        $field->save();

        return response()->json([
            'data' => $field
        ]);
    }
}
