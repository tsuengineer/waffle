<?php

namespace App\Usecases\Post;

use App\Http\Requests\Post\UpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Utils\ResponseUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UpdateAction
{
    public function __invoke(UpdateRequest $request): ResponseUtil
    {
        $data = $request->validated();
        $post = Post::query()->where('ulid', $data['ulid'])->firstOrFail();

        DB::beginTransaction();
        try {
            // postsテーブルの更新
            $post->update([
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

            // tagsテーブルの更新
            if (!empty($data['tags']) && is_array($data['tags'])) {
                $tags = collect($data['tags'])->filter()->map(function ($tagName) {
                    return Tag::query()->firstOrCreate(['name' => $tagName]);
                });

                $post->tags()->sync($tags->pluck('id'));
            }

            // commentsテーブルの更新
            $post->comments()->delete(); // 既存のコメントを削除
            if (!empty($data['comments'])) {
                $commentLines = explode("\n", trim($data['comments']));

                foreach ($commentLines as $commentLine) {
                    [$moves, $text] = explode(':', $commentLine, 2);

                    Comment::query()->create([
                        'post_id' => $post->id,
                        'moves' => (int) $moves,
                        'text' => trim($text),
                    ]);
                }
            }

            // 未使用のタグを削除
            $unusedTags = Tag::query()->whereDoesntHave('posts')->get();
            foreach ($unusedTags as $unusedTag) {
                $unusedTag->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update post.', ['exception' => $e]);
            return ResponseUtil::updateWithErrors([
                'post' => 'Failed to update post.',
                'exception' => $e->getMessage(),
            ]);
        }

        return ResponseUtil::updateSuccess();
    }
}
