<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductsCreateRequest;
use App\Http\Requests\Products\ProductsUpdateRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Products\Products;
use App\Services\Products\ProductsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    private $productsService;

    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    public function showAllProducts(Request $request): JsonResponse
    {
        return ApiResponse::success($this->productsService->showAllProducts($request));
    }
    public function createProduct(ProductsCreateRequest $productsCreatRequest): JsonResponse
    {
        return ApiResponse::success($this->productsService->createProduct($productsCreatRequest->validated()),
            'Produto cadastrado com sucesso', 201);
    }

    public function updateProduct(ProductsUpdateRequest $productsUpdateRequest, int $id): JsonResponse
    {
        $productsUpdateRequest->validated();
        try {
            return ApiResponse::success($this->productsService->updateProduct($productsUpdateRequest, $id),
                'Produto atualizado com sucesso', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Produto não encontrado', 404);
        }
    }

    public function deleteProduct(int $id): JsonResponse
    {
        try {
            $this->productsService->deleteProduct($id);
            return ApiResponse::success(null, 'Produto deletado com sucesso', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Produto não encontrado', 404);
        }
    }

    public function blockProduct(Request $request, Products $products): JsonResponse
    {
        try {
            $this->productsService->blockProduct($request, $products);
            return ApiResponse::success( [], $request['is_active'] == 1 ? 'Produto ativado com sucesso' :  'Usuário desativado com sucesso' ,201);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 'Produto não encontrado', 404);
        }
    }
}


