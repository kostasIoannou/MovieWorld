<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;

class FrontPageController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
