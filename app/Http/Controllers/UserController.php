<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // token
        if ($request->header('http-x-api-key') == config('app.APIKEY')) {

            $dados = $request->all();

            foreach ($dados as $key => $value) {
                // corrigir
                $value["address"] = "";
                $value["company"] = "";
                $validator = Validator::make($value, [
                    'name'  => 'required|min:6|max:255',
                    'email' => 'required|email|unique:users'
                ]);

                if ($validator->fails()) {
                    $erros = $validator->errors();

                    return response()->json($erros, 400);
                } 

                $user = User::create($value);

                if (!$user) {
                    return response()->json("Erro no cadastro user - id: ".$value["id"], 400);
                } else {

                }
            } 
            
            $users = User::all();

            if ($users) return response()->json("Registros cadastrados com sucesso!", 200);
            else return response()->json("Erro ao processar cadastrados!", 400);
            
        } else {
            return response()->json("Nao autorizado!", 400);
        }
    }
}
