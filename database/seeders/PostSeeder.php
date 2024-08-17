<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/data/init_post_data.tsv');
        $data = File::get($filePath);
        $lines = explode("\n", trim($data));

        // ヘッダーをスキップするために最初の行を除去
        array_shift($lines);

        foreach ($lines as $line) {
            $columns = explode("\t", $line);

            // 各列のデータを変数に割り当て
            [
                $userId,
                $title,
                $initBoard,
                $kifu,
                $initTurn,
                $startMove,
                $blackUserName,
                $whiteUserName,
                $beginText,
                $endText,
                $sort,
                $tags,
                $comments
            ] = $columns;

            // Postの作成
            $post = Post::query()->create([
                'user_id' => $userId,
                'ulid' => Str::ulid(),
                'title' => $title,
                'init_board' => $initBoard,
                'kifu' => $kifu,
                'init_turn' => $initTurn,
                'start_move' => $startMove,
                'black_user_name' => $blackUserName,
                'white_user_name' => $whiteUserName,
                'begin_text' => $beginText,
                'end_text' => $endText,
                'sort' => $sort,
            ]);

            // Tagsの登録
            if (!empty($tags)) {
                $tagNames = explode(',', $tags);
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    $tag = Tag::query()->firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }
                $post->tags()->sync($tagIds);
            }

            // Commentsの登録
            if (!empty($comments)) {
                // comments列の中身はダブルクォートで囲まれたカンマ区切りのリスト
                $commentItems = explode('","', trim($comments, '"'));
                foreach ($commentItems as $commentItem) {
                    // 空文字の場合はスキップ
                    if (trim($commentItem) === '') {
                        continue;
                    }

                    [$moves, $text] = explode(':', $commentItem, 2);
                    Comment::query()->create([
                        'post_id' => $post->id,
                        'moves' => trim($moves),
                        'text' => trim($text),
                    ]);
                }
            }
        }
    }
}
