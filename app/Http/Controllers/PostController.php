<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\json_encode;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $posts = Post::all();

        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Usuario não autorizado

        $dados = $request->all();
        //dd($dados);

        foreach ($dados as $key => $value) {

            $validator = Validator::make($value, [
                'title'  => 'required|unique:posts|max:255',
                'body'   => 'required'
            ]);

            if ($validator->fails()) {
                $erros = $validator->errors();

                return response()->json($erros, 400);
            } 

            $user = User::find($value["userId"]);

            if (!$user) {
                return response()->json("Usuario nao autorizado - id: ".$value["id"], 400);
            }

            $post = Post::create($value);

            if (!$post) {
                return response()->json("Erro no cadastro do post - id: ".$value["id"], 400);
            }
        } 

        return response()->json("Registros cadastrados com sucesso!", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
