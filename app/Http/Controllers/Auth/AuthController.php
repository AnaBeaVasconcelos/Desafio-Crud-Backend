<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(AuthRegisterRequest $authRegisterRequest): JsonResponse
    {
        $authRegisterRequest->validated();

        try {
            $fields = $this->authService->register($authRegisterRequest);

            return ApiResponse::success($fields, 'Usuário cadastrado com sucesso', 201);
        }catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function login(AuthLoginRequest $authLoginRequest): JsonResponse
    {
        $authLoginRequest->validated();

        try {
            $fields = $this->authService->login($authLoginRequest);

            return ApiResponse::success($fields, 'Usuário logado com sucesso', 200);
        }catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();

            return ApiResponse::success([], 'Usuário deslogado com sucesso', 200);
        }catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
