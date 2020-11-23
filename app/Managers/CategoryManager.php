<?php


namespace App\Managers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryManager implements ManagerInterface
{
    /**
     * @return Collection[Category]
     */
    public function getAll(): Collection
    {
        return Category::query()->get();
    }

    /**
     * @param int $categoryId
     * @return Category|null
     */
    public function getById(int $categoryId): ?Category
    {
        return Category::query()
            ->where('id', $categoryId)
            ->take('1')
            ->with(['children'])
            ->get()[0] ?? null;
    }

    /**
     * @param int|null $parentId
     * @return Collection[Category]
     */
    public function getCategoriesWithParent(?int $parentId)
    {
        return Category::query()
            ->where('parent_id', $parentId)
            ->with('children')
            ->get();
    }
}
