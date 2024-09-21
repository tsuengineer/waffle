<section>
    <header>
        <h2 class="text-lg font-medium text-zinc-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-zinc-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @if($user->avatars?->path)
            <img src="{{ asset('storage/' . config('image.avatar_path') . '/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}" class="w-32 h-32" alt="アバター" />
        @endif
        <input type="file" name="avatar">

        <div>
            <x-input-label for="slug" value="ユーザーID" />
            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $user->slug)" pattern="[a-zA-Z0-9_-]+" required autofocus autocomplete="slug" />
            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-zinc-100" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-zinc-700 text-zinc-100" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-zinc-100" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-zinc-700 text-zinc-100" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-zinc-300">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-zinc-400 hover:text-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="x_account" value="X ID" />
            <x-text-input id="x_account" name="x_account" type="text" class="mt-1 block w-full" :value="old('x_account', $user->x_account)" placeholder="x_account" autocomplete="x_account" />
            <x-input-error class="mt-2" :messages="$errors->get('x_account')" />
        </div>

        <div>
            <x-input-label for="instagram_account" value="Instagram ID" />
            <x-text-input id="instagram_account" name="instagram_account" type="text" class="mt-1 block w-full" :value="old('instagram_account', $user->instagram_account)" placeholder="instagram_account" autocomplete="instagram_account" />
            <x-input-error class="mt-2" :messages="$errors->get('instagram_account')" />
        </div>

        <div>
            <x-input-label for="profile" value="自己紹介" />
            <x-form.input-textarea id="profile" name="profile" type="text" class="mt-1 block w-full" :value="old('profile', $user->profile)" autocomplete="profile" />
            <x-input-error class="mt-2" :messages="$errors->get('profile')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-zinc-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
