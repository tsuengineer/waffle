<?php

namespace App\Usecases\Post;

use App\Http\Requests\Post\DestroyRequest;
use App\Models\Post;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DestroyAction
{
    public function __invoke(DestroyRequest $request): ResponseUtil
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $post = Post::query()->where('ulid', $data['ulid'])->firstOrFail();
            $userId = $post->user_id;
            $sortValue = $post->sort;

            $post->tags()->detach();
            $post->comments()->delete();
            $post->delete();

            Post::query()
                ->where('user_id', $userId)
                ->where('sort', '>', $sortValue)
                ->decrement('sort');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete post.', ['exception' => $e]);
            return ResponseUtil::deleteWithErrors([
                'post' => 'Failed to delete post.',
                'exception' => $e->getMessage(),
            ]);
        }

        return ResponseUtil::deleteSuccess();
    }
}
