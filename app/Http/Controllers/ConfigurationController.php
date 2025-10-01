<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sidebar;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function configuration(){
        return Inertia::render('Config/Configuration',[
            'sidebar' => 'Settings',
            'menu' => 'SystemSetup',
        ]);
    }

    public function sidebar()
    {
        $sidebars = Sidebar::orderByRaw('CAST(position AS UNSIGNED) ASC')->get();
        return Inertia::render('Config/Sidebar',[
            'sidebar'=>'Settings',
            'menu' => 'Sidebar',
            'sidebars'=>$sidebars,
        ]);
    }
}
