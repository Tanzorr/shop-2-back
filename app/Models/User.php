<?php

namespace App\Models;


use App\Scopes\UserCategoryScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticated;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticated
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['media',];

    public function scopeFilterBySearch(Builder $query, $search = ''): Builder
    {
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return $query;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)->withoutGlobalScope(UserCategoryScope::class);
    }

    public function sharedVaultsRelation(): HasManyThrough
    {
        return $this->hasManyThrough(
            Category::class,
            SharedAccess::class,
            'user_id',
            'id',
            'id',
            'accessible_id'
        )
            ->where('shared_accesses.accessible_type', Category::class)
            ->addSelect([
                'categories.*',
                'shared_accesses.user_id as shared_user_id',
                'shared_accesses.id as shared_access_id',
            ]);
    }

    public function getMediaAttribute()
    {
        return $this->media()->get();
    }
    public function media(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable', 'media_relations');
    }
}
