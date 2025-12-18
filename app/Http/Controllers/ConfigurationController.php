<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sidebar;
use Illuminate\Http\Request;
use App\Models\MySetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ConfigurationController extends Controller
{
    public function configuration()
    {
        $settings = MySetting::get();
        return Inertia::render('Config/Configuration', [
            'sidebar' => 'Settings',
            'menu' => 'System Setup',
            'settings' => $settings,
        ]);
    }

    public function configurationApi(){
        $settings = MySetting::get();
        $data = [];
        foreach($settings as $setting){
            $data[$setting->key] = $setting->value;
        }
        return response()->json($data);
    }

    public function sidebar()
    {
        $sidebars = Sidebar::orderByRaw('CAST(position AS UNSIGNED) ASC')->get();
        return Inertia::render('Config/Sidebar', [
            'sidebar' => 'Settings',
            'menu' => 'Sidebar',
            'sidebars' => $sidebars,
        ]);
    }

    public function configurationUpdate(Request $request)
    {
        // Validate the incoming data
        // return $request;
        $validatedData = $request->validate([
            'date_type' => 'required|string',
            'date_format' => 'required|string',
            // Add validation rules for your keys here
        ]);

        // Start a database transaction for atomic operations
        DB::beginTransaction();


        try {
            // Loop through all the data and update or create settings
            foreach ($validatedData as $key => $value) {
                MySetting::updateOrCreate(
                    ['key' => $key],  // Check if the key exists
                    ['value' => $value]  // Update or create the new value
                );
            }

            // return $validatedData;
            // Commit the transaction if everything is fine
            DB::commit();

            // Return success message
            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error message for debugging
            Log::error('Error updating settings: ' . $e->getMessage());

            // Return error message
            return redirect()->back()->with('error', 'An error occurred while updating settings.');
        }
    }

    public function SidebarManagement(Request $request)
    {
        return $request;
        $from = Sidebar::where('position', $request->from)->first();
        $to = Sidebar::where('position', $request->to)->first();

        $from->update(['position' => $request->to]);
        $to->update(['position' => $request->from]);

        // $sidebars = $request->input('sidebars', []);

        // foreach ($sidebars as $index => $sidebarData) {
        //     if (isset($sidebarData['id'])) {
        //         // Update existing sidebar
        //         Sidebar::where('id', $sidebarData['id'])->update([
        //             'position' => $index + 1, // Assuming position starts from 1
        //         ]);
        //     }
        // }

        return response()->json(['message' => 'Sidebar positions updated successfully']);
    }
}
