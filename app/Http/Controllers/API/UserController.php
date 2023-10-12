<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRequest $request){

        try{

            $user=new User();

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password,['rounds'=>12]);


        $user->save();

        return response()->json([
            'status_code'=>200,
            'status_message'=>"utilisateur ajouté avec succès",
            'data'=>$user
        ]);

        }catch(Exception $e){
            return response()->json($e);
        }

    }

    public function login(LoginUserRequest $request){
        if(auth()->attempt($request->only(['email','password']))){
            $user=Auth()->user();

            $token = $request->user()->createToken('MA_CLE_SECRETE_UNIQUEMENT_POUR_LE_BACKEND')->plainTextToken;

            return response()->json([
                'status_code'=>200,
                'status_message'=>"utilisateur connecté",
                'user'=>$user,
                'token'=>$token


            ]);

        }else{
            return response()->json([
                'status_code'=>403,
                'status_message'=>"Informations non valide",

            ]);
        }
    }
}
