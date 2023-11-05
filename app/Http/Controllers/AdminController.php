<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function Dashboard()
    {
        $analytics_dataset = [
            'users_count' => Cache::remember('users_count', 60*60*24, function () {
                return User::where('rule', 'advertiser')->count();
            }),
            'today_ads' => Cache::remember('today_ads', 60*60*24, function () {
                return Advertisement::whereDate('created_at', Carbon::today())->count();
            }),
        ];
        return view('admin.dashboard.index', compact(['analytics_dataset']));
    }

    public function AdsManager(Request $request)
    {
        if ($request->isMethod('GET')) {
            $advertisements = Advertisement::with('user');
            if ($request->has('query')) {
                $advertisements
                    ->where('title', 'LIKE', "%{$request->get('query')}%")
                    ->orWhere('desc', 'LIKE', "%{$request->get('query')}%")
                    ->orWhere('city', 'LIKE', "%{$request->get('query')}%")
                    ->orWhere('province', 'LIKE', "%{$request->get('query')}%")
                    ->orWhereRelation('user', 'name', 'LIKE', "%{$request->get('query')}%");
            }

            if ($request->has('sort')) {
                $advertisements->orderBy($request->get('sort'), 'DESC');
            } else {
                $advertisements->orderBy('confirmed');
            }
            $advertisements = $advertisements->paginate(25)->withQueryString();
            return view('admin.advertisements.index', compact(['advertisements']));
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'ad_id' => 'required|exists:App\Models\Advertisement,id',
                'ad_confirmed' => 'required|boolean'
            ]);
            Advertisement::where('id', $request['ad_id'])->update(['confirmed' => $request['ad_confirmed']]);
            return redirect()->back();
        } else {
            abort(403, 'Unathorized action.');
        }
    }

    public function EditUser($id)
    {
        return User::find($id);
    }

    public function AdsPreview($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $translations = $this->translations;
        return view('admin.advertisements.adsPreview', compact(['advertisement', 'translations']));

    }
}
