<?php

namespace App\Actions;

use App\Contracts\QueryInterface;
use App\Contracts\ReadActionInterface;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class GetCategoryAction implements ReadActionInterface
{
    public function handle(QueryInterface $query): LengthAwarePaginator
    {
        return Category::filterBySearch($query->get('search'))
            ->orderBy('created_at', 'desc')
            ->paginate();
    }
}
