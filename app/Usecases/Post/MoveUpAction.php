<?php

namespace App\Usecases\Post;

use App\Http\Requests\Post\MoveUpRequest;
use App\Models\Post;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoveUpAction
{
    public function __invoke(MoveUpRequest $request): ResponseUtil
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $post = Post::query()
                ->where('ulid', $data['ulid'])
                ->firstOrFail();

            $previousPost = Post::query()
                ->where('user_id', $post->user_id)
                ->where('sort', $post->sort - 1)
                ->firstOrFail();

            $post->sort -= 1;
            $previousPost->sort += 1;

            $post->save();
            $previousPost->save();

            DB::commit();
        } catch (\Exception $e) {
            Log::error('Failed to move post.', ['exception' => $e]);
            return ResponseUtil::moveWithErrors(['post' => 'Failed to move post.', 'exception' => $e->getMessage()]);
        }

        return ResponseUtil::moveSuccess();
    }
}
