<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInsertSeriesRequest extends FormRequest
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
                'name' => 'required|min:5|max:60',
                'text' => 'required|min:20',
                'year' => 'required|regex:/^[\d]{4}$/',
                "img" => "required|file|mimes:jpg,jpeg,gif,png|max:2000",
                "category" => "required|not_in:0",
                "glumci" => "required|min:4"
        ];
    }
    public function messages()
    {
        return [

            'name.regex' => "Ime mora imati od 5 do 60 karaktera!",
            'text.regex' => 'Tekst mora imati najmanje 20 karaktera!',
            'year.regex' => 'Godina mora imati četiri cifre!',
            "img.mimes" => "Nije dozvoljena ekstenzija!",
            "img.max" => "Maksimalna veličina slike je 2 MB!",
            "img.required" => "Slika nije odabrana!",
            "category.not_in" => "Kategorija nije izabrana!",
            "glumci.min" =>"Mora biti izabrano najmanje 4 glumca!"
        ];
    }
}
