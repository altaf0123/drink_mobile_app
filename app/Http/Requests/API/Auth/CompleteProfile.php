<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CompleteProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->account_verified;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'gender'=>'required|in:male,female',
            // 'profile_picture'=>'required',
            // 'location_range'=>'required',
            'name'=>'required',
            // 'date_of_birth'=>'required|date|date_format:Y-m-d|before:today',
        ];
    }
}
