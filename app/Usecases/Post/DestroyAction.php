<?php

namespace App\Usecases\Post;

use App\Http\Requests\Post\DestroyRequest;
use App\Models\Post;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\Log;

class DestroyAction
{
    public function __invoke(DestroyRequest $request): ResponseUtil
    {
        $data = $request->validated();

        try {
            $post = Post::query()->where('ulid', $data['ulid'])->firstOrFail();

            $post->tags()->detach();
            $post->comments()->delete();
            $post->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete post.', ['exception' => $e]);
            return ResponseUtil::deleteWithErrors(['post' => 'Failed to delete post.', 'exception' => $e->getMessage()]);
        }

        return ResponseUtil::deleteSuccess();
    }
}
