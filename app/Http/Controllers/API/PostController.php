<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

class PostController extends Controller
{
    function index(Request $request){

        try{

            $query=Post::query();
            $per_page=2;
            $page=$request->input('page', '1');
            $search=$request->input('search');

            if($search){
                $query->whereRaw("titre LIKE '%" . $search . "%'");

            }
            $total=$query->Count();
            $result=$query->offset(($page-1)*$per_page)->limit($per_page)->get();
            return response()->json([
                'status_code'=>200,
                'status_message'=>"tous les articles",
                'current_page'=>$page,
                // 'last_page'=>ceil($total / $per_page),
                'items'=>$result
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    public function store(CreatePostRequest $request ){

        Try{
            // $post=new Post();
            // $post->titre=$request->titre;
            // $post->description=$request->description;
            // $post->prix=$request->prix;
            // $post->user_id=$request->user()->id;

            $data = $request->json()->all();

        // Créez une nouvelle instance de Post avec les données JSON
            $post = new Post();
            $post->titre = $data['titre'];
            $post->description = $data['description'];
            $post->prix = $data['prix'];
            $post->user_id = Auth()->user()->id;
            // dd($post);
            $post->save();

            return response()->json([
                'status_code'=>200,
                'status_message'=>"l'enregistrement effectué avec succès",
                'data'=>$post
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }

    public function editer(EditPostRequest $request,Post $post){
        try{
            //$post=Post::find($id);
            $post->titre=$request->titre;
            $post->description=$request->description;
            $post->prix=$request->prix;
            //dd($post);
            if($post->user_id==Auth()->user()->id){
                $post->save();
            }else{
                return response()->json([
                    'status_code'=>422,
                    'status_message'=>"vous n'etes pas l'auteur de ce post",
                    
                ]);
            }
            

            return response()->json([
                'status_code'=>200,
                'status_message'=>"Modification effectué avec succès",
                'data'=>$post
            ]);

        }catch(Exception $e){
            return response()->json($e);
        }
    }

    public function delete(Post $post){
        try{
            if($post->user_id==Auth()->user()->id){
                $post->delete();
            }else{
                return response()->json([
                    'status_code'=>422,
                    'status_message'=>"vous n'etes pas l'auteur de ce post,suppression non authorisée",
                    
                ]);
            }
            
            return response()->json([
                'status_code'=>200,
                'status_message'=>"Suppression effectué avec succès",
                'data'=>$post
            ]);
        }catch(Exception $e){
            return response()->json($e);
        }
    }


}
