<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class AdvertisementStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|min:4',
            'phone' => 'required|string|numeric',
            'business_name' => 'required|min:4',
            'business_category' => 'required|json',
            'work_hours' => 'required|json',
            'off_days' => 'required|json',
            'address' => 'required|string|min:10',
            'business_number' => 'required|string|numeric',
            // @todo: make a method for optimizing huge user uploaded files
            'business_images.*' =>  File::types(['jpg', 'png', 'webp'])
                ->min('10kb')
                ->max('3mb'),
            'province' => 'required',
            'city' => 'required',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ];
    }
}
