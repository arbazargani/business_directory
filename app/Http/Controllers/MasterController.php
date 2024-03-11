<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\SearchQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isNull;

class MasterController extends Controller
{
    public function Index() {
        $advertisements = [
            'commercial' => Advertisement::whereConfirmed(1)
                ->whereDate('published_at', '<=', Carbon::today())
                ->whereDate('expires_at', '>=', Carbon::today())
                ->withCount('comments')->where('ad_level', 'commercial')
                ->limit(100)->orderBy('comments_count', 'DESC')->get(),
        ];

        $translations = $this->translations;
        return view('public.index', compact(['advertisements', 'translations']));
    }

    public function Search(Request $request)
    {
        $limit = ($request->has('limit')) ? $request['limit'] : 100;
        $advertisements = Advertisement::whereConfirmed(1)
            ->whereDate('published_at', '<=', Carbon::today())
            ->whereDate('expires_at', '>=', Carbon::today());
        if ($request->has('sort') && $request['sort'] !== null) {
            $advertisements = $advertisements->orderBy($request['sort'], 'DESC');
        } else {
            $advertisements = $advertisements->withCount('comments')->orderBy('comments_count', 'DESC');
        }
        $translations = $this->translations;

        // determine main param [search_query] sets or not.
        if ($request->has('search_query')) {
            // append main query string to collection
            $query = trim($request['search_query']);
            $advertisements->where('title', 'like', "%$query%");

            // append search location to where clauses
            if ($request->has('search_location') && !is_null($request->get('search_location')) && $request->get('search_location') !== '-1') {
                $province = $request->get('search_location');
                $advertisements->where('iran_province_id', $province);
            }

            // append search location to where clauses
            if ($request->has('search_city') && !is_null($request->get('search_city')) && $request->get('search_city') !== '-1') {
                $city = $request->get('search_city');
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
                : $advertisements->limit($limit)->get()->groupBy('ad_level');
        }

        // if query worth, add to queries table, for suggestion to another users
        if ($ads->count() >= 5 && strlen($request['search_query']) >= 3) {
            // $query = $request['search_query'];
            // $row = SearchQuery::where('query', 'like', "%$query%");
            // if ($row->count() == 1) {
            //     $row->update([
            //         'last_trigger' => now(),
            //         'is_top' => ($ads->count() > 20) ? 1 : 0
            //     ]);
            //     $row->increment('hits');
            // } else {
            //     $sq = new SearchQuery();
            //     $sq->query = $query;
            //     $sq->last_trigger = now();
            //     $sq->save();
            // }
        }

        return view('public.search', compact(['ads', 'translations']));

    }

    public function Sample()
    {
        return 'here is masterController Class.';
    }

    public function GuestAdvertisement()
    {
            if (Auth::check() && Auth::user()->rule == 'advertiser') {
                return redirect()->route('Advertiser > Form');
            }

            return view('public.guest_ad');
    }
}
