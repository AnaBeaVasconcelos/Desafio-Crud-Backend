<?php

namespace App\Repositories\Products;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Products\Products;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Products::class);
    }

    public function showAllProducts($request): LengthAwarePaginator
    {
        return $this->getModel()::
        when(isset($request['search']), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        })
            ->with('category')
            ->paginate();

    }
    public function blockProduct($request, $products): bool
    {
        $products->is_active = $request['is_active'];
        return $products->save();
    }
}
