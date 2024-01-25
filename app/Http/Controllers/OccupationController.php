<?php

namespace App\Http\Controllers;

use App\Models\Occupation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OccupationController extends Controller
{
    function toEnglishDigit($string)
    {
        $en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $fa_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($fa_num, $en_num, $string);
    }

    function toPersianDigit($string)
    {
        $en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $fa_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        return str_replace($en_num, $fa_num, $string);
    }

    function convertArabicStringToPersian($string)
    {
        $arabic = array('ي', 'ك', 'ة');
        $farsi = array('ی', 'ک', 'ه');
        return str_replace($arabic, $farsi, $string);
    }

    public function standardQuery($q)
    {
        return $this->toEnglishDigit($this->convertArabicStringToPersian($q));
    }

    public function ListOccupations(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($request->has('q') && $request->get('q') != '') {
                $q = $this->standardQuery($request['q']);
                $specs = Occupation::where('active', 1)
                    ->where('id', 'LIKE', "%$q%")
                    ->orWhere('name', 'LIKE', "%$q%")
                    ->orWhere('translations', 'LIKE', "%$q%")
                    ->get();
                $result_array = [];
                foreach ($specs as $item) {
                    $result_array[] = (object) [
                        'id' => $item->id,
                        'label' => $item->name,
                        'type' => ['- گروه شغلی'],
                    ];
                }

                $response = [
                    'request' => $request->fullUrl(),
                    'result' => [
                        'code' => 200,
                        'msg' => 'Success',
                        'list' => $result_array,
                    ],
                ];

                $response = (object) $response;

                return response()->json($response);
            }
        }
    }
}
