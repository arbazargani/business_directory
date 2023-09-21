<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdvertiserController extends Controller
{
    public function Panel()
    {
        return view('advertiser.panel.index');
    }

    public function addAdvertise(Request $request)
    {
        // validating incoming request for creating advertisement
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:4',
            'phone' => 'required|string|numeric',
            'business_name' => 'required|min:4',
            'business_category' => 'required|json',
            'work_hours' => 'required|json',
            'off_days' => 'required|json',
            'address' => 'required|string|min:10',
            'business_number' => 'required|string|numeric',
            'instagram' => 'string|min:4',
            'telegram' => 'string|min:4',
            'whatsapp' => 'string|min:4',
            'eitaa' => 'string|min:4',
            'other_social_1' => 'string|min:4',
            'other_social_2' => 'string|min:4',
            // @todo resolve error for business image filed
//            'business_images' => 'required|json',
            'province' => 'required|string|min:4',
            'city' => 'required|string|min:4',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ]);

        // handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'ts' => time(),
                'error' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ]);
        }

        $advertisement = new Advertisement();
        $advertisement->title = $request['business_name'];
        $advertisement->desc = '';
        $advertisement->confirmed = 0;

        // @todo solve unloggedin users, or think for a new way to handle this issue
        $advertisement->user_id = (Auth::check()) ? Auth::id() : 1;

        $advertisement->fullname = (Auth::check()) ? Auth::user()->name : $request['fullname'];
        $advertisement->phone = (Auth::check()) ? Auth::user()->phone_number : $request['phone'];
        $advertisement->business_name = $request['business_name'];
        $advertisement->business_categories = $request['business_category'];
        $advertisement->work_hours = $request['work_hours'];
        $advertisement->off_days = $request['off_days'];
        $advertisement->address = $request['address'];
        $advertisement->business_number = $request['business_number'];
        $advertisement->social_media = json_encode([
            'instagram' => $request['instagram'],
            'telegram' => $request['telegram'],
            'whatsapp' => $request['whatsapp'],
            'eitaa' => $request['eitaa'],
            'other_social_1' => $request['other_social_1'],
            'other_social_2' => $request['other_social_2']
        ]);
        $advertisement->business_images = $request['business_images'];
        $advertisement->province = $request['province'];
        $advertisement->city = $request['city'];
        $advertisement->latitude = $request['lat'];
        $advertisement->longitude = $request['lng'];
        $advertisement->published_at = now();
        $advertisement->save();


        return response()->json([
            'status' => 200,
            'allowed' => true,
            'timestamp' => time(),
            'messages' => [
                'fa' => 'با موفقیت اضافه شد.',
                'en' => 'advertisement successfully submitted.',
            ],
        ]);

        return redirect()->back()->with(['message' => 'با موفقیت ثبت شد.']);
    }
}
