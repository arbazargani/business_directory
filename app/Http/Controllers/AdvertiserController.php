<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AdvertisementStoreRequest;
use App\Models\Advertisement;
use App\Models\Business;
use App\Models\IranCity;
use App\Models\IranProvince;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Morilog\Jalali\CalendarUtils;
use function PHPUnit\Framework\isNull;

class AdvertiserController extends Controller
{
    public function Panel(Request $request)
    {
        $advertisements = Advertisement::where('user_id', Auth::id());
        $advertisements = ($request->has('sort')) ? $advertisements->orderBy($request->get('sort'), 'DESC')->get() : $advertisements->latest()->get();
        return view('advertiser.panel.index', compact(['advertisements']));
    }

    public function AddAdvertise()
    {
        return view('advertiser.panel.addAvertise');
    }

    public function SubmitAdvertise(AdvertisementStoreRequest $request)
    {
        // incoming request validation will be handled inside AdvertisementStoreRequest class.
        // check if the user isn't login, first we make user account for him.
        if (!Auth::check()) {
            $phoneChecker = User::where('phone_number', $request['phone'])->get();
            if ($phoneChecker->count() == 1) {
                return response()->json([
                    'status' => 400,
                    'timestamp' => time(),
                    'allowed' => false,
                    'errors' => [
                        'fa' => 'شماره قابل استفاده نیست.',
                        'en' => 'Phone number can not be used.'
                    ],
                ]);
            }
            $user = new User();
            $user->name = $request['fullname'];
            $user->phone_number = $request['phone'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['phone']);
            $user->save();
            Auth::login($user, true);
        }

        $advertisement = new Advertisement();
        $advertisement->title = $request['business_name'];
        $advertisement->confirmed = 0;
        $advertisement->country_level_service = (int) $request['country_level_service'];
//        $advertisement->package_id = $request['package'];

        // @todo solve unloggedin users, or think for a new way to handle this issue
        $advertisement->user_id = (Auth::check()) ? Auth::id() : 1;

        $advertisement->fullname = (Auth::check()) ? Auth::user()->name : $request['fullname'];
        $advertisement->phone = (Auth::check()) ? Auth::user()->phone_number : $request['phone'];
        $advertisement->business_name = $request['business_name'];
        $advertisement->business_categories = $request['business_category'];
        $advertisement->work_hours = $request['work_hours'];
        $advertisement->off_days = $request['off_days'];
        $advertisement->address = $request['address'];
        $advertisement->desc = $request['description'];
        $advertisement->business_number = $request['business_number'];
        $advertisement->social_media = json_encode([
            'website' => $request['website'],
            'instagram' => $request['instagram'],
            'telegram' => $request['telegram'],
            'whatsapp' => $request['whatsapp'],
            'eitaa' => $request['eitaa'],
            'other_socials' => json_decode($request['other_socials']),
        ]);

        // @todo: create a Media model to handle user uploads better than any time!
        if ($request->hasFile('business_images')) {
            $business_images_backpack = [];
            $loop = 0;
            foreach ($request->file('business_images') as $image) {
                $loop ++;
                $hashName = $image->hashName();
                $extension = $image->extension();
                $defaultName = time().'-'.$hashName;
                $seoName = "$loop-" . str_replace(' ', '-', $request['business_name']) . ".$extension";
                $seoName = $this->clearFileName($seoName);
                $path = $image->storeAs('uploads/'.Auth::id(), $seoName, 'public');
                $business_images_backpack[] = $path;
            }
            $advertisement->business_images = json_encode($business_images_backpack);
        }

        $advertisement->province = IranProvince::find($request['province'])->name;
        $advertisement->iran_province_id = $request['province'];
        $advertisement->city = IranCity::find($request['city'])->name;
        $advertisement->iran_city_id = $request['city'];
        $advertisement->latitude = $request['lat'];
        $advertisement->longitude = $request['lng'];
        $advertisement->published_at = now();
        $advertisement->save();

        return response()->json([
            'status' => 200,
            'allowed' => true,
            'timestamp' => time(),
            'redirect' => route('Advertiser > Advertisement > Bind Package', $advertisement->id),
            'messages' => [
                'fa' => 'با موفقیت اضافه شد.',
                'en' => 'advertisement successfully submitted.',
            ],
        ]);

//        return redirect()->back()->with(['message' => 'با موفقیت ثبت شد.']);
    }
    public function BindPackageToAdvertise(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);
        if (!is_null($advertisement->transaction_id) && !is_null($advertisement->package_id)) {
//            return redirect()->route('Advertiser > Advertisement > Pay Confirm', $advertisement->id);
        }
        if ($request->isMethod('GET')) {
            $packages = Package::where('active', 1)->get();
            return view('advertiser.panel.bindPackage', compact(['advertisement', 'packages']));
        } elseif ($request->isMethod('POST')) {
            // create transaction model for advertisement
            $transaction = new Transaction();
            $transaction->advertisement_id = $advertisement->id;
            $transaction->package_id = $request['package_id'];
            $transaction->amount = Package::find($request['package_id'])->price;
            $transaction->transaction_info = json_encode([
                'created_at' => now(),
            ]);
            $transaction->save();
            // add transaction_id to advertisement
            Advertisement::where('id', $advertisement->id)->update([
                'package_id' => $request['package_id'],
                'transaction_id' => $transaction->id
            ]);

            return response()->json([
                'status' => 200,
                'allowed' => true,
                'timestamp' => time(),
                'redirect' => route('Advertiser > Advertisement > Pay Confirm', $advertisement->id),
                'messages' => [
                    'fa' => 'با موفقیت اضافه شد.',
                    'en' => 'advertisement successfully submitted.',
                ],
            ]);
        } else {
            abort('Method not allowed.');
        }

    }
    public function PayAdvertise(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $advertisement = Advertisement::findOrFail($id);
            $user_advertisements = Advertisement::where('user_id', $advertisement->user_id)->pluck('id')->toArray();
            $package = Package::findOrFail($advertisement->package_id);
            $transaction = Transaction::where('advertisement_id', $advertisement->id)->first();
            $giftUsed = Transaction::where('package_id', $package->id)
                ->where('paid', 1)
                ->whereIn('advertisement_id', $user_advertisements)
                ->count();
            return view('advertiser.panel.advertisement_payment', compact(['advertisement', 'package', 'transaction', 'giftUsed']));
        } elseif ($request->isMethod('POST')) {
            return 'post';
        } else {
            abort('403', 'unsupported method.');
        }
    }

    public function ListCities(Request $request)
    {
        $province = IranProvince::find($request->get('province'));
            if (is_null($province)) {
                return response()->json([
                    'status' => 200,
                    'timestamp' => time(),
                    'allowed' => true,
                    'province' => $province,
                    'html' => "<option data-name='همه شهرها' value='-1'>همه شهرها</option>",
                ]);
        } else {
            $output = $request->has('allCities') ? "<option data-name='همه شهرها' value='-1'>همه شهرها</option>" : '';
            foreach ($province->cities as $city) {
                $output .= "<option data-name='{$city->name}' value={$city->id}>{$city->name}</option>";
            }

            return response()->json([
                'status' => 200,
                'timestamp' => time(),
                'allowed' => true,
                'province' => $province,
                'html' => $output,
            ]);
        }
    }

    public function SubmitRating(Request $request)
    {
        $ad = Advertisement::find($request['ad_id']);
        if (!is_null($ad)) {
            $rate = $request['rate'];
            if (isset($ad->getRatings()->rating)) {
                $rate = ( ($ad->getRatings()->rating * $ad->getRatings()->voters) + $request['rate'] ) / ($ad->getRatings()->voters + 1);
            }
            $rating = [
                'voters' => isset($ad->getRatings()->voters) ? $ad->getRatings()->voters + 1 : 1,
                'rating' => $rate,
            ];
            $ad->update([
                'rating' => json_encode($rating),
            ]);
            $formatted_rating = number_format((float)$rate, 1, '.', '');
            return response()->json([
                'status' => 200,
                'allowed' => true,
                'timestamp' => time(),
                'rate' => Helper::faNum($formatted_rating),
                'messages' => [
                    'fa' => 'رای شما با موفقیت ثبت شد.',
                    'en' => 'advertisement successfully voted.',
                ],
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'timestamp' => time(),
                'allowed' => false,
                'errors' => [
                    'fa' => 'کسب و کار یافت نشد.',
                    'en' => 'Bussiness not found.'
                ],
            ]);
        }
    }

    public function ProfileManager(Request $request)
    {
        if ($request->isMethod('GET')) {
            $user = Auth::user();
            return view('advertiser.panel.profile', compact(['user']));
        }

        $request->validate([
            'name' => 'required|string|min:4',
//            'phone_number' => 'required|string|numeric|regex:/(09)[0-9]{9}/|digits:11',
            'email' => 'required|email',
            'password' => ['sometimes', 'nullable', 'confirmed', Password::min(8)],
            'gender' => 'required',
            'birthdate' => 'required',
        ]);

        $dateString = CalendarUtils::convertNumbers($request['birthdate'], true); // changes ۱۳۹۵/۰۲/۱۹ to 1395/02/19
        $birthdate = CalendarUtils::createCarbonFromFormat('Y/m/d', $dateString)->format('Y-m-d'); //2016-05-8
        User::where('id', Auth::id())->update([
            'name' => $request['name'],
//            'phone_number' => $request['phone_number'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'user_informations' => json_encode([
                'gender' => $request['gender'],
                'birthdate' => $birthdate,
            ]),
        ]);
        return redirect()->back();
    }

    private function clearFileName(string $name)
    {
        $clear_name = str_replace(['۱','۲','۳','۴','۵','۶','۷','۸','۹','۰'], [1,2,3,4,5,6,7,8,9,0], $name);
        $clear_name = str_replace(['‌','،',',','.','(',')'], null, $clear_name);
        return $clear_name;
    }
}
