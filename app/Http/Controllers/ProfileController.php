<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Usecases\Profile\IndexAction;
use App\Usecases\Profile\UpdateAction;
use Gumlet\ImageResizeException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request, IndexAction $action): View
    {
        $data = $action($request);

        return view('profile.show', $data);
    }

    public function edit(Request $request): View
    {
        return view(
            'profile.edit',
            [
                'user' => $request->user(),
            ]
        );
    }

    /**
     * @throws ImageResizeException
     */
    public function update(ProfileUpdateRequest $request, UpdateAction $action): RedirectResponse
    {
        $data = $request->validated();
        $avatarFile = $request->file('avatar');

        $action($request->user(), $data, $avatarFile);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag(
            'userDeletion',
            [
                'password' => ['required', 'current_password'],
            ]
        );

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
