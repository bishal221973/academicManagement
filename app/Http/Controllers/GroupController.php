<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::latest()->get();
        return inertia('Config/Group', [
            'menu' => 'Group',
            'sidebar' => 'Academic',
            'groups' => $groups,
            'group' => new Group(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(Group::rules());
        try {
            Group::create($data);
            // event(new CourseEvent());
            return redirect()->back()->with('success', 'Group created successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Group $group)
    {
        $group->update([
            'status' => !$group->status
        ]);
        // event(new CourseEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Group $group)
    {
        $groups = Group::latest()->get();
        return inertia('Config/Group', [
            'menu' => 'Group',
            'sidebar' => 'Academic',
            'groups' => $groups,
            'group' => $group,
        ]);
    }
    public function update(Request $request, Group $group)
    {
        $data = $request->validate(Group::rules($group->id));
        try {
            $group->update($data);
            // event(new CourseEvent());
            return redirect()->route('group.index')->with('success', 'Group updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('group.index')->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        Group::find($id)->delete();
        // event(new CourseEvent());
        return redirect()->route('group.index')->with('success', 'Group deleted successfully');
    }

    public function getGroup()
    {
        return response()->json([
            'groups' => Group::where('status', 1)->latest()->get()
        ]);
    }
}
