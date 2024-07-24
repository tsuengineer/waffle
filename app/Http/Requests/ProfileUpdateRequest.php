<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $userSlug = $this->user()->slug;

        return [
            'slug' => [
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique(User::class)->where(function ($query) use ($userSlug) {
                    return $query->where('slug', '!=', $userSlug);
                })
            ],
            'name' => [
                'string',
                'max:255'
            ],
            'email' => [
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id)
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:50000',
            ],
            'profile' => [
                'nullable',
                'string',
                'max:255'
            ],
            'x_account' => [
                'nullable',
                'string',
                'max:255'
            ],
            'instagram_account' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }
}
