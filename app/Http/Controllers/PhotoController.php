<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $photos = Photo::all();

        return response()->json($photos, 200);
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
                'title'          => 'required|max:255',
                'url'            => 'required',
                'thumbnailUrl'   => 'required'
            ]);

            if ($validator->fails()) {
                $erros = $validator->errors();

                return response()->json($erros, 400);
            } 

            $album = Album::find($value["albumId"]);

            if (!$album) {
                return response()->json("Album nao existente- id: ".$value["id"], 400);
            }

            $photo = Photo::create($value);

            if (!$photo) {
                return response()->json("Erro no cadastro do photo - id: ".$value["id"], 400);
            }
        } 

        $photos = Photo::all();

        if ($photos) return response()->json("Registros cadastrados com sucesso!", 200);
        else return response()->json("Erro ao processar cadastrados!", 400);
    }
}
