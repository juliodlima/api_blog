<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

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
                return response()->json("Usuario nao existente- id: ".$value["id"], 400);
            }

            $post = Post::create($value);

            if (!$post) {
                return response()->json("Erro no cadastro do post - id: ".$value["id"], 400);
            }
        } 

        $posts = Post::all();

        if ($posts) return response()->json("Registros cadastrados com sucesso!", 200);
        else return response()->json("Erro ao processar cadastrados!", 400);
    }
}
