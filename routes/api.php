<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// recuperrer la liste des articles

Route::get('posts',[PostController::class,'index']);

//inscrire un utilisateur

Route::post('register/',[UserController::class,'register']);
Route::post('login/',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

    //ajouter un article

    Route::post('posts/ajout',[PostController::class,'store']);


    //editer un article

    Route::put('posts/edit/{post}',[PostController::class,'editer']);

    //supprimer un article

    Route::delete('posts/{post}',[PostController::class,'delete']);
    

    // utilisateur connecté

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
