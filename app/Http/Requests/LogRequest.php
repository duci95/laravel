<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
            "username" => "required|regex:/^[a-zšđčćž0-9]{6,15}$/",
            "password" => "required|regex:/^[A-ZŠĐČĆŽa-zšđčćž?!&#$%@0-9]{8,15}$/"
        ];
    }
    public function messages()
    {
        return [
            "username.regex" => "Korisničko ime ne sme biti kraće od 6 i duže od 15 karaktera!Nisu dozvoljeni specijalni karakteri i velika slova!",
            "password.regex" => "Lozinka ne sme biti kraća od 8 i duža od 15 karaktera! Dozvoljeni su specijalni karakteri i velika slova!"
        ];
    }
}
