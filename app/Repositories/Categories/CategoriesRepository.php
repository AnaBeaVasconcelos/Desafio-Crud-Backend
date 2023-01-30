<?php

namespace App\Repositories\Categories;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Categories\Categories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriesRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Categories::class);
    }

    public function showAllCategories($request): Collection
    {
        return $this->getModel()::
        when(isset($request['search']), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        })
            ->get();
    }

    public function getAll():  Collection
    {
        return $this->getModel()::all();
    }

}
