<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function Index() {
        return response()
            ->view('public.sitemap.index')
            ->header('Content-Type','text/xml');

    }

    public function Advertisement() {
        $advertisements = Advertisement::where('confirmed', 1)
            ->where('created_at','<=', Carbon::now())
            ->latest()->get();
        return response()
            ->view('public.sitemap.advertisement', compact('advertisements'))
            ->header('Content-Type','text/xml');
    }

    public function Page() {
        $pages = Page::where('state', 1)
            ->latest()->get();
        return response()
            ->view('public.sitemap.page', compact('pages'))
            ->header('Content-Type','text/xml');
    }
}
