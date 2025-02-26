<?php

namespace App\Models;

use App\Models\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property-read Model|\Eloquent $accessible
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess query()
 * @property int $id
 * @property string $accessible_type
 * @property int $accessible_id
 * @property int $user_id
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereAccessibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereAccessibleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedAccess whereUserId($value)
 * @mixin \Eloquent
 */
class SharedAccess extends Model
{
    use HasFactory;


    const ACCESS_TYPE_MAP = [
        'CategoryModel' => 'App\\Models\\Category',
        'PasswordModel' => 'App\\Models\\Product',
    ];

    protected $fillable = [
        'accessible_type',
        'accessible_id',
        'user_id',
        'access_level',
        'expires_at',
    ];

    public function accessible(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
