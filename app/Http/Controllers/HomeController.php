<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Your code here to handle the home page
        return view('welcome'); // or whatever view you want to return
    }
}
