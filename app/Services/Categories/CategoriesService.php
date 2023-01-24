<?php

namespace App\Services\Categories;

use App\Repositories\Categories\CategoriesRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use TheSeer\Tokenizer\Exception;

class CategoriesService
{
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function showAllCategories($request = null): LengthAwarePaginator
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
            'is_active' => $categoriesCreateRequest['is_active']
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
            'is_active' => $categoriesUpdateRequest['is_active']
        ]);

        return true;
    }

    public function deleteCategories($id): void
    {
        $categories = $this->categoriesRepository->find($id);

        if (!$categories) {
            throw new Exception('Categoria não encontrada');
        }

        $categories->delete();
    }

    public function blockCategories($request, $categories): bool
    {
        $categories->is_active = $request['is_active'];
        return $categories->save();
    }
}
