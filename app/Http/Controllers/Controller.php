<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $translations;
    public $settings;
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
