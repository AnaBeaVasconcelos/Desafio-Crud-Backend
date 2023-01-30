<?php

namespace App\Services\Products;

use App\Models\Products\Products;
use App\Repositories\Products\ProductsRepository;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\NoReturn;
use PhpParser\Node\Stmt\DeclareDeclare;
use TheSeer\Tokenizer\Exception;

class ProductsService
{
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function showAllProducts($request = null): Collection
    {
        return $this->productsRepository->showAllProducts($request);
    }

    public function createProduct($productsCreatRequest): Builder|Model
    {
        return $this->productsRepository->create([
            'name' => $productsCreatRequest['name'],
            'description' => $productsCreatRequest['description'],
            'price' => $productsCreatRequest['price'],
            'quantity' => $productsCreatRequest['quantity'],
            'category_id' => $productsCreatRequest['category_id'],
        ]);
    }

    public function updateProduct($productsUpdateRequest, $id): bool
    {
        $product = $this->productsRepository->find($id);

        if (!$product) {
            throw new Exception('Produto não encontrado');
        }

        $product->update([
            'name' => $productsUpdateRequest['name'],
            'description' => $productsUpdateRequest['description'],
            'price' => $productsUpdateRequest['price'],
            'quantity' => $productsUpdateRequest['quantity'],
            'category_id' => $productsUpdateRequest['category_id'],
        ]);

        return true;
    }

    public function deleteProduct($id): void

    {
        $product = $this->productsRepository->find($id);

        $product->delete();
    }

    public function blockProduct($request, $products): bool
    {
       return $this->productsRepository->blockProduct($request, $products);
    }

}
