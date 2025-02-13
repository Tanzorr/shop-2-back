<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function storeProduct(array $data): Product
    {
        return $this->saveProduct(new Product(), $data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return $this->saveProduct($product, $data);
    }

    private function saveProduct(Product $product, array $data): Product
    {
        DB::beginTransaction();
        try {
            $product->fill($data);
            $product->save();

            if (!empty($data['tags'])) {
                $tags = $this->getOrCreateTags($data['tags']);
                $product->tags()->sync($tags);
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
        return collect($tagNames)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName])->id;
        })->toArray();
    }
}
