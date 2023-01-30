<?php

namespace App\Repositories\Products;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Products\Products;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductsRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Products::class);
    }
    public function showAllProducts($request): Collection
    {
        return $this->getModel()::
            when(isset($request['search']), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query('search') . '%');
            })
            ->with('category')
            ->get();
    }

    public function blockProduct($request, $products): bool
    {
        $products->is_active = $request['is_active'];
        return $products->save();
    }
}
