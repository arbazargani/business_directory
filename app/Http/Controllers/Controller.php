<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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
}
