<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $purchase_price
 * @property string|null $sale_price
 * @property int $stock
 * @property string $sku
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 *
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static Builder<static>|Product filterByCategory(?int $categoryId)
 * @method static Builder<static>|Product filterByTags(array $tagIds = [])
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product search(?string $keyword)
 * @method static Builder<static>|Product whereCategoryId($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereDescription($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product wherePurchasePrice($value)
 * @method static Builder<static>|Product whereSalePrice($value)
 * @method static Builder<static>|Product whereSku($value)
 * @method static Builder<static>|Product whereStock($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'sku',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, fn ($q) => $q->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%"))
            ->orWhere('purchase_price', 'LIKE', "%{$keyword}%")
            ->orWhere('sale_price', 'LIKE', "%{$keyword}%");
    }

    public function scopeFilterByCategory(Builder $query, ?int $categoryId): Builder
    {
        return $query->when($categoryId, fn ($q) => $q->where('category_id', $categoryId));
    }

    public function scopeFilterByTags(Builder $query, array $tagIds = []): Builder
    {
        return $query->when(! empty($tagIds), fn ($q) => $q->whereHas('tags', fn ($tq) => $tq->whereIn('tags.id', $tagIds)));
    }
}
