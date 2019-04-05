<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
            "ime" => "regex:/^[A-ZŠĐČĆŽa-zšđžčć\s]{2,25}$/",
            "prezime" => "regex:/^[A-ZŠĐČĆŽa-zšđžčć\s]{2,25}$/",
            "email" => "email"
        ];
    }
    public function messages()
    {
       return [
         "ime.regex" => "Ime nije u dobrom formatu",
         "prezime.regex" => "Prezime nije u dobrom formatu",
         "email.email" => "Email nije u dobrom formatu"
       ];
    }
}