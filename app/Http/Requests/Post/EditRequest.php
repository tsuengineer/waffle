<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'ulid' => ['required', 'string']
        ];
    }

    public function validationData()
    {
        return array_merge(
            parent::validationData(),
            [
                'ulid' => Route::input('ulid')
            ],
        );
    }
}
