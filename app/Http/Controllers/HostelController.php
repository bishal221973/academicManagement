<?php

namespace App\Http\Controllers;

use App\Events\HostelEvent;
use App\Models\Hostel;
use App\Models\HostelStudent;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HostelController extends Controller
{
    public function index()
    {
        $hostels = Hostel::with('rooms','students')->latest()->get();
        return Inertia::render('Hostel/Hostel', [
            'hostels' => $hostels,
            'hostel' => new Hostel(),
            'menu' => 'Hostel',
            'sidebar' => 'Hostel',
        ]);
    }

    public function all()
    {
        $hostels = Hostel::latest()->where('status', 1)->get();

        return response()->json([
            'hostels' => $hostels
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate(Hostel::rules());

        Hostel::create($data);
        event(new HostelEvent());
        return redirect()->back()->with('success', "New hostel have been saved.");
    }
    public function show(Hostel $hostel, Request $request){
        $hostel->load('rooms','students');
        $room=Room::with('students')->find($request->room_id);
        $hostelStudents = HostelStudent::with('student', 'hostel', 'room')->latest()->get();
        return Inertia::render('Hostel/HostelShow', [
            'hostel' => $hostel,
            'menu' => 'Hostel',
            'sidebar' => 'Hostel',
            'room'=>$room,
            'hostelStudents'=>$hostelStudents,
        ]);
    }
    public function updateStatus(Hostel $hostel)
    {
        $hostel->update([
            'status' => !$hostel->status
        ]);
        event(new HostelEvent());

        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Hostel $hostel)
    {
        $hostels = Hostel::with('rooms','students')->latest()->get();
        return Inertia::render('Hostel/Hostel', [
            'hostels' => $hostels,
            'hostel' => $hostel,
            'menu' => 'Hostel',
            'sidebar' => 'Hostel',
        ]);
    }

    public function update(Request $request, Hostel $hostel)
    {
        $data = $request->validate(Hostel::rules());

        $hostel->update($data);
        event(new HostelEvent());


        return redirect()->route('hostel.index')->with('success', "Selected hostel have been updated.");
    }

    public function destroy($id)
    {
        Hostel::find($id)->delete();
        event(new HostelEvent());


        return redirect()->route('hostel.index')->with('success', "Selected hostel have been removed.");
    }
}
