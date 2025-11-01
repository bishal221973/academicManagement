<?php

namespace App\Http\Controllers;

use App\Models\AdmissionField;
use App\Models\MySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AcademySetupController extends Controller
{
    public function index()
    {
        $settings = MySetting::get();
        return Inertia::render("Config/AcademySetup", [
            'sidebar' => 'Settings',
            'menu' => 'AcademySetup',
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'academy_name'       => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'academy_email'      => 'required|email|max:255',
            'reg_date'           => 'nullable|date',
            'academy_contact_no' => 'nullable|string|max:50',
            'vat_no'             => 'nullable|string|max:50',
            'logo'               => 'nullable',
        ]);

        DB::beginTransaction();

        try {
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $validatedData['logo'] = $request->file('logo')->store('logo', 'public');
            }

            // Loop through validated data and update or create settings
            foreach ($validatedData as $key => $value) {
                MySetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating settings: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating settings.');
        }
    }

    public function getLogo()
    {
        $logo = MySetting::where('key', 'logo')->first();

        return response()->json("/storage/" . $logo->value);
    }

    public function reOrder(Request $request)
    {
        $group = $request->input('group');
        $ids = $request->input('ids');

        foreach ($ids as $index => $id) {
            AdmissionField::where('id', $id)->update(['position' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
