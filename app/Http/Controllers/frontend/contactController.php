<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class contactController extends Controller
{
    public function contact()
    {

        return view('frontend.layout.contact');

    }
}
