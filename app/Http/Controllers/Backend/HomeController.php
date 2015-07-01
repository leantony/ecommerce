<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;


class HomeController extends Controller
{

    /**
     * Displays the backend home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.index');
    }

}