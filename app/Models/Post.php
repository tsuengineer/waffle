<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ulid',
        'title',
        'init_board',
        'kifu',
        'start_move',
        'black_user_name',
        'white_user_name',
        'begin_text',
        'end_text',
        'sort',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeSearchPosts(Builder $query, array $searchData)
    {
        return $query->with('user', 'user.avatars')
            ->where(function ($query) use ($searchData) {
                $query->where('title', 'like', "%{$searchData['keyword']}%");
            })
            ->when($searchData['tag'], function ($query) use ($searchData) {
                $query->whereHas('tags', function ($query) use ($searchData) {
                    $query->where('name', $searchData['tag']);
                });
            });
    }
}
