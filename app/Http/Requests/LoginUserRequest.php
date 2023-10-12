<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserRequest extends FormRequest
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
            'email'=>'required|email|exists:users,email',
            'password'=>'required'
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
            'email.required'=>'une adresse mail doit être fourni',
            'email.email'=>"email non valide",
            'email.exists'=>'cet adresse mail n\'existe pas',
            'password.required'=>'un password doit être fourni'
        ];
    }
}
