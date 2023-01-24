<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoriesCreateRequest;
use App\Http\Requests\Categories\CategoriesUpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Categories\Categories;
use Exception;
use App\Services\Categories\CategoriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function showAllCategories(Request $request): JsonResponse
    {
        return ApiResponse::success($this->categoriesService->showAllCategories($request));
    }

    public function getAll(): JsonResponse
    {
        return ApiResponse::success($this->categoriesService->getAll());
    }

    public function createCategories(CategoriesCreateRequest $categoriesCreateRequest): JsonResponse
    {
        return ApiResponse::success($this->categoriesService->createCategories($categoriesCreateRequest->validated()),
            'Categoria cadastrada com sucesso', 201);
    }

    public function updateCategories(CategoriesUpdateRequest $categoriesUpdateRequest, int $id): JsonResponse
    {
        $categoriesUpdateRequest->validated();
        try {
            return ApiResponse::success($this->categoriesService->updateCategories($categoriesUpdateRequest, $id),
                'Categoria atualizada com sucesso', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Categoria não encontrada', 404);
        }
    }

    public function deleteCategories(int $id): JsonResponse
    {
        try {
            $this->categoriesService->deleteCategories($id);
            return ApiResponse::success(null, 'Categoria deletada com sucesso', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Categoria não encontrada', 404);
        }
    }

    public function blockCategories(Request $request, Categories $categories): JsonResponse
    {
        try {
            $this->categoriesService->blockCategories($request, $categories);
            return ApiResponse::success( [], $request['is_active'] == 1 ? 'Categoria ativada com sucesso' :  'Categoria desativada com sucesso' ,201);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Categoria não encontrada', 404);
        }
    }
}
