<?php

namespace App\Http\Controllers;

use App\Models\MailFormat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MailFormatController extends Controller
{
     public function index()
    {
        $mailFormats = MailFormat::latest()->get();
        return Inertia::render('Config/MailFormat', [
            'sidebar' => 'Settings',
            'menu' => 'mailFormats',
            'mailFormats' => $mailFormats,
        ]);
    }
}
