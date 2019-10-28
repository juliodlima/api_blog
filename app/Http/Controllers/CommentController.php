<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $comments = Comment::all();

        return response()->json($comments, 200);
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
                'name'   => 'required|unique:comments|max:255',
                'email'  => 'required',
                'body'   => 'required'
            ]);

            if ($validator->fails()) {
                $erros = $validator->errors();

                return response()->json($erros, 400);
            } 

            $post = Post::find($value["postId"]);

            if (!$post) {
                return response()->json("Post nao existente- id: ".$value["id"], 400);
            }

            $comment = Comment::create($value);

            if (!$post) {
                return response()->json("Erro no cadastro do comment - id: ".$value["id"], 400);
            }
        } 

        $coments = Comment::all();

        if ($coments) return response()->json("Registros cadastrados com sucesso!", 200);
        else return response()->json("Erro ao processar cadastrados!", 400);
    }
}
