<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $users->each(function ($user) {
            $posts = Post::factory(5)->create(['user_id' => $user->id]);

            $posts->each(function ($post) {
                Comment::factory(3)->create(['post_id' => $post->id]);
            });
        });

        $tags = Tag::factory(10)->create();

        Post::all()->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $users->each(function ($user) {
            Avatar::factory()->create(['user_id' => $user->id]);
        });
    }
}
