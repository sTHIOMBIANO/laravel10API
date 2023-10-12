<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required'
        ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json([
            'success'=>false,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorsList'=>$validator->errors()
        ]));
    }

    public function messages(){
        return[
            'name.required'=>'un nom doit être fourni',
            'email.required'=>'un email doit être fourni',
            'email.unique'=>'cette adresse mail existe déja',
            'password.required'=>'un password doit être fourni'

        ];
    }

}
