<?php

namespace App\Usecases\Search;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexAction
{
    public function __invoke(array $searchData): LengthAwarePaginator
    {
        return Post::query()->searchPosts($searchData)
            ->orderBy('created_at', $searchData['order'])
            ->paginate(40);
    }
}
