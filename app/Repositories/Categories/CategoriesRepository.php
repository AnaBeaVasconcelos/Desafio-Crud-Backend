<?php

namespace App\Repositories\Categories;

use App\Contracts\Repository\AbstractRepository;
use App\Models\Categories\Categories;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoriesRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->setModel(Categories::class);
    }

    public function showAllCategories($request): LengthAwarePaginator
    {
        return $this->getModel()::
        when(isset($request['search']), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->query('search') . '%');
        })
            ->paginate();
    }
}
