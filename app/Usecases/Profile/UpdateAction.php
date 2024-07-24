<?php

namespace App\Usecases\Profile;

use App\Models\Avatar;
use App\Models\User;
use Gumlet\ImageResizeException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Gumlet\ImageResize;

class UpdateAction
{
    /**
     * @throws ImageResizeException
     */
    public function __invoke(User $user, array $data, ?UploadedFile $avatarFile): void
    {
        unset($data['avatar']);
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        Log::info('user save');
        $user->save();

        // アバターの登録
        if ($avatarFile) {
            Log::info('avatar');

            // 現在のアバター情報
            $currentAvatar = Avatar::where('user_id', $user->id)->first();

            $filename = Str::random(6) . '.webp';

            // Gumlet/php-image-resizeを使用して画像をリサイズ
            $image = new ImageResize($avatarFile->getPathname());
            $image->resize(300, 300);
            $image->save(public_path('avatars/' . $filename));

            // アバターが既に存在すれば更新、なければ新規作成
            $avatar = $user->avatars ?? new Avatar(['user_id' => $user->id]);
            $avatar->path = $filename; // 新しいアバターのパスを設定
            $avatar->save();

            // 保存先
            $directory = user_directory_path($user->id);

            // 古いアバターを削除
            if ($currentAvatar) {
                Storage::disk('direct')->delete(
                    config('image.avatar_path') . '/' . $directory . '/' . $currentAvatar->path
                );
            }

            // storageディレクトリに保管
            Storage::disk('direct')->put(
                config('image.avatar_path') . '/' . $directory . '/' . $filename,
                file_get_contents(public_path('avatars/' . $filename))
            );

            // 一時ファイルを削除
            unlink(public_path('avatars/' . $filename));
        }
    }
}
