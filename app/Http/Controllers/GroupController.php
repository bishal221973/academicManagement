<?php

namespace App\Http\Controllers;

use App\Events\GroupEvent;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::latest()->with('parent')->get();
        return inertia('Config/Group', [
            'menu' => 'Group Management',
            'sidebar' => 'Academic',
            'groups' => $groups,
            'group' => new Group(),
        ]);
    }

    public function all(){
        $groups=Group::latest()->get();

        return response()->json([
            "groups"=>$groups
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = $request->validate(Group::rules());
        try {
            Group::create($data);
            event(new GroupEvent());
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
        event(new GroupEvent());
        return response()->json([
            'message' => 'Status updated successfully'
        ]);
    }

    public function edit(Group $group)
    {
        $groups = Group::latest()->get();
        return inertia('Config/Group', [
            'menu' => 'Group Management',
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
            event(new GroupEvent());
            return redirect()->route('group.index')->with('success', 'Group updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('group.index')->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        Group::find($id)->delete();
        event(new GroupEvent());
        return redirect()->route('group.index')->with('success', 'Group deleted successfully');
    }

    public function getGroup()
    {
        return response()->json([
            'groups' => Group::where('status', 1)->latest()->get()
        ]);
    }
}
