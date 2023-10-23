<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function Lottery()
    {
        $ads = Advertisement::all()->pluck('id')->toArray();
        shuffle($ads);
        for ($i = 0; $i < 4; $i ++) {
            Advertisement::find($ads[$i])->update([
                'ad_level' => 'comercial'
            ]);
        }
    }
}
