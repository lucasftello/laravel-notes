<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function handleLogin(Request $request)
    {
        // Validate the request data
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Preencha o campo email',
                'email.email' => 'O email deve ser um endereço de email válido',
                'password.required' => 'Preencha o campo senha',
            ]
        );

        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)
            ->where('deleted_at', NULL)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            return back()
                ->withErrors(['loginError' => 'Email ou senha inválidos']);
        }

        $user->last_login = now();
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);

        return redirect()->route('notes');
    }

    public function register()
    {
        return view('register');
    }

    public function handleRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ], [
            'name.required' => 'Preencha o campo nome',
            'name.string' => 'O nome deve ser uma string',
            'name.min' => 'O nome deve ter pelo menos :min caracteres',
            'name.max' => 'O nome deve ter no máximo :max caracteres',
            'email.required' => 'Preencha o campo email',
            'email.email' => 'O email deve ser um endereço de email válido',
            'email.unique' => 'Esse email já está cadastrado',
            'password.required' => 'Preencha o campo senha',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'password_confirmation.required' => 'Corfirme sua senha',
            'password_confirmation.min' => 'A confirmação da senha deve ter pelo menos :min caracteres',
        ]);

        $emailExists = User::where('email', $request->email)
            ->where('deleted_at', NULL)
            ->exists();

        if ($emailExists) {
            return back()
                ->withErrors(['registerError' => 'Esse email já está cadastrado']);
        }

        if ($request->password !== $request->password_confirmation) {
            return back()
                ->withErrors(['registerError' => 'As senhas não conferem']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()
            ->route('login')
            ->with('registerSuccess', 'Cadastro realizado com sucesso');
    }

    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login');
    }
}
