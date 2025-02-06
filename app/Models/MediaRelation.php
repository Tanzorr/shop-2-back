<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Media|null $media
 * @property-read Model|\Eloquent $mediable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MediaRelation query()
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


    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
