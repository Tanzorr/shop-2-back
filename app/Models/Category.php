<?php

namespace App\Models;


use App\Scopes\UserCategoryScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * 
 *
 * @property-read TFactory|null $use_factory
 * @property-read Collection<int, Product> $passwords
 * @property-read int|null $passwords_count
 * @property-read Collection<int, SharedAccess> $sharedAccess
 * @property-read int|null $shared_access_count
 * @method static Builder<static>|Category filterBySearch($search = '')
 * @method static Builder<static>|Category newModelQuery()
 * @method static Builder<static>|Category newQuery()
 * @method static Builder<static>|Category query()
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|Category whereCreatedAt($value)
 * @method static Builder<static>|Category whereDescription($value)
 * @method static Builder<static>|Category whereId($value)
 * @method static Builder<static>|Category whereName($value)
 * @method static Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function scopeFilterBySearch(Builder $query, $search = ''): Builder
    {
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        return $query;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function sharedAccess(): MorphMany
    {
        return $this->morphMany(SharedAccess::class, 'accessible');
    }

    public function accessedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shared_accesses', 'accessible_id', 'user_id')
            ->where('accessible_type', SharedAccess::VAULT_TYPE)
            ->select(['users.*', 'shared_accesses.id as shared_access_id']);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserCategoryScope);
    }
}
