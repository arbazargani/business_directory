<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public $translations;
    public function __construct()
    {
        $this->translations = [
            'week_days' => [
                'saturday' => 'شنبه',
                "sunday" => 'یکشنبه',
                "monday" => "دوشنبه",
                "tuesday" => "سه شنبه",
                "wednesday" => "چهار شنبه",
                "thursday" => "پنج شنبه",
                "friday" => "جمعه",
            ],
        ];
    }

    public function Index() {
        $advertisements = [
            'basic' => Advertisement::where('ad_level', 'basic')->limit(6)->latest()->get(),
            'comercial' => Advertisement::where('ad_level', 'comercial')->limit(3)->latest()->get()
        ];
        $translations = $this->translations;
//        return view('public.index')->with(['advertisements' => $advertisements]);
        return view('public.index', compact(['advertisements', 'translations']));
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
