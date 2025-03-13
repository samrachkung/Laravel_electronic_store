<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class aboutController extends Controller
{
    public function about()
    {

        return view('frontend.layout.about');

    }
}
