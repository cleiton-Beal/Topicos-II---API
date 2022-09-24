<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestLogin;
use App\Http\Requests\RequestUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function CreateUser(RequestUser $request) {
        try {
            $user = $request->all();
            $user['password'] = Hash::make($request->password);
            $user =  User::create($user);
            return response()->json(['Sucesso' => true, 'Mensagem' => 'Usuário criado com sucesso!' ]);

        }
        catch (Exception $e) {
            Log::info($e);
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Ocorreram erros ao criar usuário, entre em contato com o suporte!']);
        }
    }

    public function Login(RequestLogin $request) {
        Log::info($request->all());
        $user = User::where('email', $request->email)->first();
        Log::info($user);
        if (!$user) {
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Autenticação inválida!']);
        }

        if (Hash::check($request->password, $user->password)) {
            return response()->json(['Sucesso' => true, 'Token' => $user->createToken('API')->plainTextToken]);
        }
        else {
            return response()->json(['Sucesso' => false, 'Mensagem' => 'Autenticação inválida!']);
        }

    }
}
