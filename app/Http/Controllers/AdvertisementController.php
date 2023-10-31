<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
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
    public function Show(Advertisement $advertisement, $slug)
    {
        Advertisement::where('id', $advertisement->id)->increment('hits', 1);
        $ad = $advertisement;
        $comments = Comment::where('advertisement_id', $ad->id)
                    ->where('active', 1)->latest()->get();
        $translations = $this->translations;
        $related_ads = Advertisement::where('id', '!=', $ad->id)->whereJsonContains('business_categories', $ad->getCategories())->limit(3)->get();
        return view('public.advertisement', compact(['ad', 'related_ads', 'comments', 'translations']));
    }
    public function SubmitComment(Request $request, $ad_id)
    {
        $request->validate([
            'comment_content' => 'required|string|min:4',
        ]);

        $cm = new Comment();
        $cm->user_id = Auth::id();
        $cm->advertisement_id = $request['ad_id'];
        $cm->content = $request['comment_content'];
        $cm->active = 0;
        $cm->save();

        return redirect()->back()->with(['message' => 'نظر شما با موفقیت ثبت شد.']);

    }
}
