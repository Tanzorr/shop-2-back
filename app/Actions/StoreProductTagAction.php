<?php

namespace App\Actions;

use App\Contracts\MutationActionInterface;
use App\Models\Product;
use App\Models\Tag;

class StoreProductTagAction implements MutationActionInterface
{

    public function handle(array $data): mixed
    {

        $product = Product::create($data);

        if (isset($validated['tags'])) {
            $tags = collect($validated['tags'])->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName])->id;
            });

            $product->tags()->sync($tags);
        }

        return $product;
    }
}
