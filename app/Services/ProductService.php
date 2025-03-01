<?php

namespace App\Services;

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

    public function getFilteredProducts(array $filters): LengthAwarePaginator
    {
        return Product::query()
            ->search($filters['search'] ?? '')
            ->filterByCategory($filters['category_id'] ?? null)
            ->filterByTags($filters['tags_ids'] ?? [])
            ->paginate($filters['per_page'] ?? 10);
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
