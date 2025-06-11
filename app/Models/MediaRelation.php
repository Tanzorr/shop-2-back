<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $media_id
 * @property string $mediable_type
 * @property int $mediable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Media $media
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereMediableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereMediableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MediaRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'media_id',
        'mediable_type',
        'mediable_id',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
