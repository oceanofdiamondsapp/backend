<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function orders()
    {
        return view('pages.orders');
    }
    
    public function settings()
    {
        return view('pages.settings');
    }
}
