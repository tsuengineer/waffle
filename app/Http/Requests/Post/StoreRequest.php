<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $kifuLength = (int)(strlen(request()->input('kifu') ?? 0) / 2);

        return [
            'title' => ['required', 'string', 'max:100'],
            'initBoard' => ['nullable', 'string', 'size:64', 'regex:/^[OX-]+$/'],
            'kifu' => ['nullable', 'string', 'regex:/^([a-hA-H][1-8])+$/', 'max:120'],
            'initTurn' => ['required', 'in:black,white'],
            'startMove' => ['nullable', 'integer', 'min:0', 'max:' . $kifuLength],
            'blackUserName' => ['nullable', 'string', 'max:20'],
            'whiteUserName' => ['nullable', 'string', 'max:20'],
            'comments' => ['nullable', 'string', 'max:10000', 'regex:/^(?:[0-9]|[1-5][0-9]|60):.{0,100}(\r?\n|$)+$/'],
            'beginText' => ['nullable', 'string', 'max:10000'],
            'endText' => ['nullable', 'string', 'max:10000'],
            'tags' => ['nullable', 'array', 'max:10'],
            'tags.*' => ['nullable', 'string', 'max:20'],
            'ai' => ['nullable', 'boolean']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'initBoard.size' => '初期盤面は64文字である必要があります。',
            'initBoard.regex' => '初期盤面は「O」、「X」、または「-」で構成される必要があります。',
            'kifu.regex' => '棋譜は正しい形式で入力してください。',
            'kifu.max' => '棋譜は120文字以内で入力してください。',
            'kifu.even_length' => '棋譜の文字数は偶数である必要があります。',
            'initTurn.required' => '手番を選択してください。',
            'initTurn.in' => '手番は黒番または白番である必要があります。',
            'startMove.integer' => '開始手数は整数である必要があります。',
            'startMove.min' => '開始手数は0以上である必要があります。',
            'startMove.max' => '開始手数は棋譜の文字数の半分以下である必要があります。',
            'blackUserName.max' => '黒番ユーザ名は20文字以内で入力してください。',
            'whiteUserName.max' => '白番ユーザ名は20文字以内で入力してください。',
            'comments.max' => 'コメントは10000文字以内で入力してください。',
            'comments.regex' => 'コメントは各行ごとに「0～60の数字:コメント内容(100文字以内)」の形式で入力してください。',
            'beginText.max' => '盤面より上部のテキストは10000文字以内で入力してください。',
            'endText.max' => '盤面より下部のテキストは10000文字以内で入力してください。',
            'tags.array' => 'タグは配列である必要があります。',
            'tags.max' => 'タグは最大10個まで入力できます。',
            'tags.*.max' => '各タグは20文字以内で入力してください。',
            'ai.boolean' => 'AIの値は真偽値である必要があります。'
        ];
    }
}
