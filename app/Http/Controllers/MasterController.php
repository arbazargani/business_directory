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
            'commercial' => Advertisement::where('ad_level', 'commercial')->limit(3)->latest()->get()
        ];
        $translations = $this->translations;
        return view('public.index', compact(['advertisements', 'translations']));
    }

    public function Search(Request $request)
    {
        $limit = ($request->has('limit')) ? $request['limit'] : 100;
        $advertisements = Advertisement::latest();
        $translations = $this->translations;

        // determine main param [search_query] sets or not.
        if ($request->has('search_query')) {
            // append main query string to collection
            $query = trim($request['search_query']);
            $advertisements->where('title', 'like', "%$query%");

            // append search location to where clauses
            if ($request->has('search_location') && !is_null($request->get('search_location')) && $request->get('search_location') !== '-1') {
                $city = $request->get('search_location');
                $advertisements->where('iran_city_id', $city);
            }

            // prepare raw sql query string
            $query = $advertisements->getQuery()->toRawSql();

            // append request params to url
            $getParams = request()->input();

            if (!isset($getParams['search_query']) && array_search('search_query', $getParams) === false) {
                $getParams['search_query'] = '';
            }

            $ads = ($request->has('paginate'))
                ? $advertisements->paginate($request['paginate'])->appends($getParams)
                : $advertisements->limit($limit)->get();
        }

        return view('public.search', compact(['ads', 'translations']));

    }

    public function Sample()
    {
        return 'here is masterController Class.';
    }
}
