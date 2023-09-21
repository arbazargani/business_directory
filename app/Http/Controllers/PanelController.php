<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PanelController extends Controller
{
    public function Dashboard(Request $request)
    {
        return 'dashboard';
    }

    public function Advertisements(Request $request)
    {
        return 'advertisements';
    }

    public function Test()
    {
        $ads = new Advertisement();
        $ads->title = 'املاک سعیدی ۲';
        $ads->desc = 'معتبرترین املاک در منطقه تهرانپارس و شرق تهران';
        $ads->confirmed = 0;
        $ads->user_id = 1;
        $ads->published_at = now();
        $ads->save();
    }
}
