<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInsertUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username" => "required|regex:/^[a-zšđčćž0-9]{6,15}$/|unique:korisnik,username",
            "password" => "required|regex:/^[A-ZŠĐČĆŽa-zšđčćž?!&#$%@0-9]{8,15}$/",
            "firstname" => 'required|regex:/^([A-ZŠĐČĆŽ][a-zšđčćž]{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž-]{2,15})*$/',
            "lastname" => 'required|regex:/^([A-ZŠĐČĆŽ][a-zšđčćž]{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž-]{2,25})*$/',
            "email" => 'required|email',
            "passwordConfirm" => "same:password"
        ];
    }
    public function messages()
    {
        return [
          "username.unique" => "Korisnicko ime je zauzeto!"
        ];
    }
}
