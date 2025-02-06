<?php

namespace App\Models;

use App\Models\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MediaRelation> $relatedEntities
 * @property-read int|null $related_entities_count
 * @method static Builder<static>|Media filterBySearch($search = '')
 * @method static Builder<static>|Media newModelQuery()
 * @method static Builder<static>|Media newQuery()
 * @method static Builder<static>|Media query()
 * @mixin \Eloquent
 */
class Media extends Model
{
    protected $fillable = ['user_id', 'file_path', 'file_name', 'mime_type', 'size'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterBySearch(Builder $query, $search = ''): Builder
    {
        if ($search) {
            $query->where('file_name', 'like', "%{$search}%")
                ->orWhere('mime_type', 'like', "%{$search}%");
        }

        return $query;
    }

    public function relatedEntities()
    {
        return $this->morphedByMany(MediaRelation::class, 'mediable');
    }
}
