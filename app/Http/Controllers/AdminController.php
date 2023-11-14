<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\CalendarUtils;


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
            'top_8d_ads' => Cache::remember('top_8d_ads', 60*30, function () {
                return Advertisement::whereDate('published_at', '>=', now()->subDays(8))->orderBy('hits', 'DESC')->limit(10)->get();
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

    public function AdsPreview($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $translations = $this->translations;
        return view('admin.advertisements.adsPreview', compact(['advertisement', 'translations']));

    }

    public function UserManager(Request $request)
    {
        if ($request->isMethod('GET')) {
//            $users = User::whereRule('advertiser');
            $users = User::query();
            if ($request->has('query')) {
                $users
                    ->where('id', $request->get('query'))
                    ->orWhere('name', 'LIKE', "%{$request->get('query')}%")
                    ->orWhere('email', 'LIKE', "%{$request->get('query')}%")
                    ->orWhere('phone_number', $request->get('query'));
            }

            if ($request->has('sort')) {
                $users->orderBy($request->get('sort'), 'DESC');
            } else {
                $users->latest();
            }
            $users = $users->paginate(50)->withQueryString();
            return view('admin.users.index', compact(['users']));
        } else {
            abort(403, 'Unauthorized action');
        }
    }

    public function EditUser(User $user, Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('admin.users.edit', compact(['user']));
        } elseif ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required|string|min:4',
                'phone_number' => 'required|string|numeric|regex:/(09)[0-9]{9}/|digits:11',
                'email' => 'required|email',
                'password' => ['sometimes', 'nullable', 'confirmed', Password::min(8)],
                'gender' => 'required',
                'birthdate' => 'required',
            ]);

            $dateString = CalendarUtils::convertNumbers($request['birthdate'], true); // changes ۱۳۹۵/۰۲/۱۹ to 1395/02/19
            $birthdate = CalendarUtils::createCarbonFromFormat('Y/m/d', $dateString)->format('Y-m-d'); //2016-05-8

            User::where('id', $user->id)->update([
                'name' => $request['name'],
                'phone_number' => $request['phone_number'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'user_informations' => json_encode([
                    'gender' => $request['gender'],
                    'birthdate' => $birthdate,
                ]),
            ]);
            return redirect()->back();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function SettingsManager(Request $request)
    {
        if ($request->isMethod('GET')) {
            $settings =  Setting::all();
            return view('admin.settings.index', compact(['settings']));
        } elseif ($request->isMethod('POST')) {
            foreach ($request->all() as $name => $value) {
                Setting::where('name', $name)->update(['value' => $value]);
            }
            Cache::forget('site_settings');
            return redirect()->back();
        } else {
            abort(403);
        }
    }
}
