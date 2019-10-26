<?php

namespace App\Http\Controllers;

use App\Album;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $albums = Album::all();

        return response()->json($albums, 200);
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
                'title'  => 'required|unique:albums|max:255'
            ]);

            if ($validator->fails()) {
                $erros = $validator->errors();

                return response()->json($erros, 400);
            } 

            $user = User::find($value["userId"]);

            if (!$user) {
                return response()->json("Usuario nao existente- id: ".$value["id"], 400);
            }

            $album = Album::create($value);

            if (!$album) {
                return response()->json("Erro no cadastro do album - id: ".$value["id"], 400);
            }
        } 

        $albums = Album::all();

        if ($albums) return response()->json("Registros cadastrados com sucesso!", 200);
        else return response()->json("Erro ao processar cadastrados!", 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        //
    }
}
