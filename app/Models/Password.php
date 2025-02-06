<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * 
 *
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SharedAccess> $sharedAccess
 * @property-read int|null $shared_access_count
 * @property-read \App\Models\Category|null $vault
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Password newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Password newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Password query()
 * @method static \Database\Factories\PasswordFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Password extends Model
{
    use HasFactory;

    protected $fillable = [
        'vault_id',
        'name',
        'value',
        'description',
    ];

    public function sharedAccess(): MorphMany
    {
        return $this->morphMany(SharedAccess::class, 'accessible');
    }

    public function vault(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
