<?php

namespace App\Http\Controllers;

use App\Models\Sidebar;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function index(){
        $sidebars = Sidebar::orderByRaw('CAST(position AS UNSIGNED) ASC')->get();


        return response()->json([
            'datas'=>$sidebars
        ]);
    }
}
