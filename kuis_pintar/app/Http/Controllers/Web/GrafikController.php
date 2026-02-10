<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class GrafikController extends Controller
{
    public function index()
    {
        return view('web.grafik.index');
    }
}
