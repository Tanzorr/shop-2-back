<?php

namespace App\Services;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * @throws \Exception
     */
    public function storeProduct(array $data): Product
    {
        return $this->saveProduct(new Product, $data);
    }

    /**
     * @throws \Exception
     */
    public function updateProduct(Product $product, array $data): Product
    {
        return $this->saveProduct($product, $data);
    }

    public function getFilteredProducts(array $filters): array
    {
        $categoryIdsArr = !empty($filters['category_ids'])
            ? explode(',', $filters['category_ids'])
            : null;

        $paginator = Product::query()
            ->search($filters['search'] ?? '')
            ->filterByCategory($categoryIdsArr)
            ->filterByTags($filters['tags_ids'] ?? [])
            ->paginate($filters['per_page'] ?? 10);

        return $this->clearPaginatorToArray($paginator);
    }

    private function clearPaginatorToArray($paginator): array
    {
        $links = collect($paginator->linkCollection())
            ->map(function ($link) {
                $label = strip_tags($link['label']);

                if (str_contains($label, 'Previous')) {
                    $link['label'] = 'Previous';
                } elseif (str_contains($label, 'Next')) {
                    $link['label'] = 'Next';
                }

                return $link;
            })
            ->values();

        return [
            'data' => $paginator->items(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'links' => $links,
        ];
    }


    private function saveProduct(Product $product, array $data): Product
    {
        DB::beginTransaction();
        try {
            $product->fill($data)->save();

            if (! empty($data['tags'])) {
                $product->tags()->sync($this->getOrCreateTags($data['tags']));
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getOrCreateTags(array $tagNames): array
    {
        return collect($tagNames)->map(fn ($tagName) => Tag::firstOrCreate(['name' => $tagName])->id)->toArray();
    }
}
