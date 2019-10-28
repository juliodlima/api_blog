<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Geo;
use App\Models\Company;
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
        // autenticação via token
        if ($request->header('http-x-api-key') == config('app.key')) {
            $dados = $request->all();

            foreach ($dados as $key => $value) {

                $validator = Validator::make($value, [
                    'name'  => 'required|min:6|max:255',
                    'email' => 'required|email|unique:users'
                ]);

                if ($validator->fails()) {
                    $erros = $validator->errors();

                    return response()->json($erros, 400);
                } 

                // cadastro geo
                $geo = Geo::create($value["address"]["geo"]);
                $value["address"]["geo"] = $geo->id;

                // cadastro address
                $address = Address::create($value["address"]);
                $value["address"] = $address->id;

                // cadastro company
                $company = Company::create($value["company"]);
                $value["company"] = $company->id;

                $user = User::create($value);

                if (!$user) {
                    return response()->json("Erro no cadastro user - id: ".$value["id"], 400);
                } 
            } 
            
            $users = User::all();

            if ($users) return response()->json("Registros cadastrados com sucesso!", 200);
            else return response()->json("Erro ao processar cadastrados!", 400);
            
        } else {
            return response()->json("Nao autorizado!", 401);
        }
    }
}
