<?php

namespace App\Usecases\Post;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreAction
{
    public function __invoke(StoreRequest $request): ResponseUtil
    {
        $data = $request->validated();
        $post = null;

        try {
            $post = Post::create([
                'user_id' => Auth::id(),
                'ulid' => Str::ulid(),
                'title' => $data['title'],
                'init_board' => $data['initBoard'],
                'kifu' => Str::upper($data['kifu']),
                'init_turn' => $data['initTurn'],
                'start_move' => $data['startMove'] ?? 0,
                'black_user_name' => $data['blackUserName'],
                'white_user_name' => $data['whiteUserName'],
                'begin_text' => $data['beginText'],
                'end_text' => $data['endText'],
            ]);

            if (!empty($data['tags']) && is_array($data['tags'])) {
                $tags = collect($data['tags'])->filter()->map(function ($tagName) {
                    return Tag::query()->firstOrCreate(['name' => $tagName]);
                });

                $post->tags()->sync($tags->pluck('id'));
            }
        } catch (\Exception $e) {
            if (!is_null($post)) {
                $post->delete();
            }
            Log::error('Failed to save post.', ['exception' => $e]);
            return ResponseUtil::createWithErrors(['post' => 'Failed to save post.', 'exception' => $e->getMessage()]);
        }

        return ResponseUtil::createSuccess();
    }
}
