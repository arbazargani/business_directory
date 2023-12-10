<?php

namespace App\Http\Controllers;

use App\Helpers\MelliPayamadkDriver;
use App\Helpers\MelliPayamakDriver;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\CalendarUtils;

class AuthController extends Controller
{
    public function GenerateOtp(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|min:11|max:11',
        ]);

        // handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'error' => $validator->errors(),
            ]);
        }

        // accessing model
        $user = User::where('phone_number', $request['phone_number'])->first();

        // check if model doesn't exist, generate error response
        if (is_null($user)) {
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'errors' => [
                    'fa' => 'شماره وارد شده در سیستم عضو نمی‌باشد.',
                    'en' => 'Phone number isn\'t registered.',
                ],
            ]);
        } else {
            // if model exists, generate otp & assign to user for 1 minutes
            $user->otp = (env('APP_ENV') == 'production') ? $this->UnicastOtp($user->phone_number) : 123;
            $user->otp_expires_at = Carbon::now()->addMinutes(1);
            $user->save();

            // return successful response
            return response()->json([
                'status' => 200,
                'phone_number' => $request['phone_number'],
                'messages' => [
                    'fa' => 'رمز یکبارمصرف برای شما ارسال شد.',
                    'en' => 'Otp hass been sent to you & is valid for 1 minuets.',
                ],
            ]);
        }
    }

    public function UnicastOtp($user_number)
    {
        error_log('generating otp code ...');
        $handle = MelliPayamakDriver::otp($user_number);
        return $handle->code;
    }

    public function ValidateOtp(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|min:11|max:11',
            'otp' => 'required|string|min:3',
        ]);

        // handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'otp' => $request['otp'],
                'error' => $validator->errors(),
            ]);
        }

        // accessing model
        $user = User::where('phone_number', $request['phone_number'])->first();

        // check if model doesn't exist, generate error response
        if (is_null($user)) {
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'errors' => [
                    'fa' => 'درخواست موردنظر قابل انجام نمی‌باشد.',
                    'en' => 'We cannot process received request.',
                ],
            ]);
        } else {
            // check if otp isn't expired or isn't correct
            if (Carbon::now()->isAfter($user->otp_expires_at) || $request['otp'] != $user->otp) {

                // generate error response
                return response()->json([
                    'status' => 400,
                    'phone_number' => $request['phone_number'],
                    'errors' => [
                        'fa' => 'رمز وارد شده معتبر نیست.',
                        'en' => 'Invalid one time password.',
                    ],
                ]);
            } else {
                // login user, remember user & generate successful response
                Auth::login($user, true);

                $log = LogController::insert('یک ورود به حساب کاربری شما صورت گرفت.', 'login', $user->id);
                if(!App::isLocal()) {
                    LogController::sendSMS("$log <br> ronagh.com", $user->phone_number);
                }

                return response()->json([
                    'status' => 200,
                    'phone_number' => $request['phone_number'],
                    'allowed' => true,
                    'timestamp' => time(),
                    'messages' => [
                        'fa' => 'با موفقیت وارد شدید.',
                        'en' => 'You have successfully logged in.',
                    ],
                ]);
            }
        }
    }

    public function ValidatePhone(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|min:11|max:11',
        ]);

        // handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'error' => $validator->errors(),
            ]);
        }

        // checking models for preventing duplicate registration.
        $user = User::where('phone_number', $request['phone_number'])->first();

        // check if model doesn't exist, generate success response
        if (is_null($user)) {
            return response()->json([
                'status' => 200,
                'phone_number' => $request['phone_number'],
                'allowed' => true,
                'timestamp' => time(),
                'messages' => [
                    'fa' => 'شماره مجاز به ثبت‌نام می‌باشد.',
                    'en' => 'Allowed to register with phone number.',
                ],
            ]);
        } else {
            // if phone number exists in model, generate forbidden response
            return response()->json([
                'status' => 400,
                'phone_number' => $request['phone_number'],
                'errors' => [
                    'fa' => 'شماره مجاز به ثبت‌نام نمی‌باشد.',
                    'en' => 'Can\'t register phone number.',
                ],
            ]);
        }
    }

    public function Login(Request $request)
    {
        if ($request->isMethod('GET')) {
            if (Auth::check()) {
                if (Auth::user()->getRule() == 'advertiser') {
                    return redirect()->route('Advertiser > Panel');
                } elseif (Auth::user()->getRule() == 'admin') {
                    return redirect()->route('Admin > Dashboard');
                } else {
                    return abort(403, 'Bad request.');
                }
            }

            return view('auth.login');
        } else {
            return abort(403, 'Bad request.');
        }
    }

    public function Register(Request $request)
    {
        if ($request->isMethod('GET')) {
            if (Auth::check()) {
                return redirect()->route('Panel > Dashboard');
            }

            return view('auth.register');
        } elseif ($request->isMethod('POST')) {
            // validating incoming request for registration
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|min:4',
                'email' => 'required|email|unique:App\Models\User,email',
                'phone_number' => 'required|string|numeric|regex:/(09)[0-9]{9}/|digits:11|unique:App\Models\User,phone_number',
                'data.birthdate' => 'required|string|min:10|max:10',
            ]);

            // handle validation failure
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'phone_number' => $request['phone_number'],
                    'error' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ]);
            }

            // handle registration request

            // convert birthdate from jalali to gregorian
            $data = $request['data'];
            $birthdate = $data['birthdate'];
            $dateString = CalendarUtils::convertNumbers($birthdate, true); // changes ۱۳۹۵/۰۲/۱۹ to 1395/02/19
            $data['birthdate'] = CalendarUtils::createCarbonFromFormat('Y/m/d', $dateString)->format('Y-m-d'); //2016-05-8

            // create user model
            $user = new User();
            $user->name = $request['full_name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['phone_number']);
            $user->phone_number = $request['phone_number'];
            $user->preferred_auth_type = 'otp';
            $user->user_informations = (object)$data;
            $user->save();

            $log = LogController::insert('ثبت نام شما با موفقیت صورت گرفت.', 'register', $user->id);

            return response()->json([
                'status' => 200,
                'phone_number' => $request['phone_number'],
                'allowed' => true,
                'timestamp' => time(),
                'messages' => [
                    'fa' => 'ثبت‌نام با موفقیت انجام شد.',
                    'en' => 'Successfully registered.',
                ],
            ]);
        } else {
            return abort(405);
        }
    }

    public function Logout()
    {
        Auth::logout();
        return redirect()->route('Auth > Login');

        if (Auth::check()) {
            Auth::logout();
//            return redirect()->route('Auth > Login');
            return response()->json([
                'status' => 200,
                'allowed' => true,
                'timestamp' => time(),
                'messages' => [
                    'fa' => 'با موفقیت خارج شدید.',
                    'en' => 'Successfully signed out.',
                ],
            ]);
        } else {
            return abort('404');
        }
    }

}
