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
 * @property int $id
 * @property int $user_id
 * @property string $file_path
 * @property string $file_name
 * @property string $mime_type
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|Media whereCreatedAt($value)
 * @method static Builder<static>|Media whereFileName($value)
 * @method static Builder<static>|Media whereFilePath($value)
 * @method static Builder<static>|Media whereId($value)
 * @method static Builder<static>|Media whereMimeType($value)
 * @method static Builder<static>|Media whereSize($value)
 * @method static Builder<static>|Media whereUpdatedAt($value)
 * @method static Builder<static>|Media whereUserId($value)
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
