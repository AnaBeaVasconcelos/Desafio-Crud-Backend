<?php

namespace App\Services\Categories;

use App\Repositories\Categories\CategoriesRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use TheSeer\Tokenizer\Exception;

class CategoriesService
{
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function showAllCategories($request = null): Collection
    {
        return $this->categoriesRepository->showAllCategories($request);
    }

    public function getAll(): Collection
    {
        return $this->categoriesRepository->getAll();
    }

    public function createCategories($categoriesCreateRequest): Builder|Model
    {
        return $this->categoriesRepository->create([
            'name' => $categoriesCreateRequest['name'],
        ]);
    }

    public function updateCategories($categoriesUpdateRequest, $id): bool
    {
        $categories = $this->categoriesRepository->find($id);
        if (!$categories) {
            throw new Exception('Categoria não encontrada');
        }

        $categories->update([
            'name' => $categoriesUpdateRequest['name'],
        ]);

        return true;
    }

    public function deleteCategories($id): void
    {

        $categories = $this->categoriesRepository->find($id);

        $products = DB::table('products')
            ->where('category_id', $id)
            ->get();

        if($products->count() > 0){
            throw new Exception('Categoria não pode ser deletada, pois possui produtos vinculados');
        }

        $categories->delete();

    }

    public function blockCategories($request, $categories): bool
    {
        $categories->is_active = $request['is_active'];
        return $categories->save();
    }
}
