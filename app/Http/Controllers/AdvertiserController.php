<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class AdvertiserController extends Controller
{
    public function Panel()
    {
        $advertisements = Auth::user()->advertisements;
        return view('advertiser.panel.index', compact(['advertisements']));
    }

    public function AddAdvertise()
    {
        return view('advertiser.panel.addAvertise');
    }

    public function SubmitAdvertise(Request $request)
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
//            'instagram' => 'string|min:4',
//            'telegram' => 'string|min:4',
//            'whatsapp' => 'string|min:4',
//            'eitaa' => 'string|min:4',
            // @todo: make a method for optimizing huge user uploaded files
            'business_images.*' =>  File::types(['jpg', 'png'])
                ->min('10kb')
                ->max('3mb'),
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
            'other_socials' => json_decode($request['other_socials']),
        ]);

        if ($request->hasFile('business_images')) {
            $business_images_backpack = [];
            $loop = 0;
            foreach ($request->file('business_images') as $image) {
                $loop ++;
                $hashName = $image->hashName();
                $extension = $image->extension();
                $defaultName = time().'-'.$hashName;
                $seoName = "$loop-" . str_replace(' ', '-', $request['business_name']) . ".$extension";

                $path = $image->storeAs('uploads/'.Auth::id(), $seoName, 'public');
                $business_images_backpack[] = $path;
            }
            $advertisement->business_images = json_encode($business_images_backpack);
        }

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
