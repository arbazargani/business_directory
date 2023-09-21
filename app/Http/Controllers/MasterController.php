<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{

    public function Index() {
        return view('home.index');
    }

    public function Search() {
        return view('home.search');
        return $this;

    }

    public function Sample()
    {
        return 'here is masterController Class.';
    }
}
