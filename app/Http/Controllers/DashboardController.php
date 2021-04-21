<?php

namespace App\Http\Controllers;

use App\Models\Template;

class DashboardController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(20);

        return view('dashboard', [
            'templates' => $templates
        ]);
    }
}
