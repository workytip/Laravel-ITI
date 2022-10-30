<?php

namespace App\Http\Requests;

use App\Rules\Postsnumber;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'title'=>['required','unique:posts','min:3','max:50'],
            'description'=>['required','min:10'],
            'post_creator'=>['exists:users,id',new Postsnumber],
            'image' => 'image|mimes:png,jpg|max:4048',
        ];
    }
}
