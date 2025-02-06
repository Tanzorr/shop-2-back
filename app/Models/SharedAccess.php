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
 * @mixin \Eloquent
 */
class SharedAccess extends Model
{
    use HasFactory;

    const VAULT_TYPE = 'App\\Models\\Category';

    const ACCESS_TYPE_MAP = [
        'VaultModel' => 'App\\Models\\Category',
        'PasswordModel' => 'App\\Models\\Password',
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
