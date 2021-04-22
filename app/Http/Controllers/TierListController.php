<?php

namespace App\Http\Controllers;

use App\Models\Template;

class TierListController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Template $template)
    {
        return view('users.tierlists.newtierlist', [
            'template' => $template
        ]);
    }
}
