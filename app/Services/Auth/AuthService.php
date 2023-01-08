<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
use Illuminate\Support\Facades\Hash;
use TheSeer\Tokenizer\Exception;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register($authRegisterRequest) :array
    {
        $user =  $this->authRepository->create([
            'name' => $authRegisterRequest['name'],
            'email' => $authRegisterRequest['email'],
            'password' => bcrypt($authRegisterRequest['password']),
        ]);

        $token = $user->createToken($authRegisterRequest->nameToken)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login($authLoginRequest): array
    {
        $user = $this->authRepository->login($authLoginRequest);

        if (!$user || !Hash::check($authLoginRequest['password'], $user->password)) {
            throw new Exception('E-mail ou senha inválidos');
        }

        $token = $user->createToken('UsuarioLogado')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
