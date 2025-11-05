<?php

namespace App\Http\Controllers;

use App\Models\Hostel;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->with('hostel','students')->get();
        return Inertia::render('Hostel/Room', [
            'menu' => 'Room',
            'sidebar' => 'Hostel',
            'rooms' => $rooms,
            'room' => new Room()
        ]);
    }

    public function all(Request $request)
    {
        
        $rooms = Room::query()
            ->latest();
            
        if ($request->hostel_id) {
            $rooms=$rooms->where('hostel_id', $request->hostel_id);
            $rooms = $rooms->get();
        } else{
            $rooms = null;
        }

        return response()->json([
            'rooms' => $rooms,
        ]);
    }
    public function store(Request $request)
    {

        $data = $request->validate(Room::rules());
        try {

            Room::create($data);

            return redirect()->back()->with('success', 'New room have been saved.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Room $room)
    {
        $room->update([
            'status' => !$room->status
        ]);
        // event(new SectionEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Room $room)
    {
        $rooms = Room::latest()->with('hostel','students')->get();
        return Inertia::render('Hostel/Room', [
            'menu' => 'Room',
            'sidebar' => 'Hostel',
            'rooms' => $rooms,
            'room' => $room
        ]);
    }

    public function show($roomId)
    {
        $room = Room::with('hostel')->findOrFail($roomId);
        return response()->json([
            'room' => $room,
        ]);
    }

    public function update(Request $request, Room $room)
    {

        $data = $request->validate(Room::rules($room->id));
        try {

            $room->update($data);

            return redirect()->route('room.index')->with('success', 'New room have been saved.');
        } catch (\Throwable $e) {
            return redirect()->route('room.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Room::find($id)->delete();
            return redirect()->route('room.index')->with('success', 'New room have been saved.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('room.index')->with('error', $e->getMessage());
        }
    }
}
