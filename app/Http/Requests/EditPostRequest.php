<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditPostRequest extends FormRequest
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
            'titre'=>'required',
            'prix'=>'required'
        ];
    }

    public function failedValidate(Validator $validator){

        throw new HttpResponseException(response()->json([
            'success'=>false,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorsList'=>$validator->errors()
        ]));
    }

    public function messages(){
        return[
            'titre.required'=>'un titre doit être fourni',
            'prix.required'=>'un prix doit être fourni'
        ];
    }
}
