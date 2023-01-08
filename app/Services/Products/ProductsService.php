<?php

namespace App\Services\Products;

use App\Repositories\Products\ProductsRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TheSeer\Tokenizer\Exception;

class ProductsService
{
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function showAllProducts(): Collection
    {
        return $this->productsRepository->all();
    }

    public function createProduct($productsCreatRequest): Builder|Model
    {
        return $this->productsRepository->create([
            'name' => $productsCreatRequest['name'],
            'description' => $productsCreatRequest['description'],
            'price' => $productsCreatRequest['price'],
            'quantity' => $productsCreatRequest['quantity'],
            'is_active' => $productsCreatRequest['is_active']
        ]);
    }

    public function updateProduct($productsUpdateRequest, $id)
    {
        $product = $this->productsRepository->find($id);

        if ($product === null) {
            throw new Exception();
        }

        $product->update([$productsUpdateRequest]);
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = $this->productsRepository->find($id);

        $product->delete();
    }
}
