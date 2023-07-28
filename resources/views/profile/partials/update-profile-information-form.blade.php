@include('components.select2')

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="initials" :value="__('Initials')" />
            <x-text-input id="initials" name="initials" type="text" class="mt-1 block w-full" :value="old('initials', $user->initials)" />
            <x-input-error class="mt-2" :messages="$errors->get('initials')" />
        </div>

        <div class="mt-4">
            <x-input-label for="birth" :value="__('Birth')" />
            <x-text-input
                id="birth"
                class="block mt-1 w-full"
                type="date"
                name="birth"
                :value="old('birth', $user->birth->format('Y-m-d'))"
                required
                autofocus
                autocomplete="birth"
            />
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label
            for="nationality"
            class=block
            appearance-none
            w-full bg-gray-200
            border
            border-gray-200
            text-gray-700
            py-3
            px-4
            pr-8
            rounded
            leading-tight
            focus:outline-none
            focus:bg-white
            focus:border-gray-500"
            id="grid-state">Nationality</label>
            <select name="nationality" class="basic-single-select2" required >
                @foreach(array_column(\App\Enums\Nations::cases(), 'value') as $option)
                    <option
                        value="{{ $option }}"
                        @if($user->nationality == $option)
                            selected
                        @endif
                    >
                        {{$option}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label
            for="naturalness"
            class=block
            appearance-none
            w-full bg-gray-200
            border
            border-gray-200
            text-gray-700
            py-3
            px-4
            pr-8
            rounded
            leading-tight
            focus:outline-none
            focus:bg-white
            focus:border-gray-500"
            id="grid-state">Naturalness</label>
            <select name="naturalness" class="basic-single-select2" required >
                @foreach(array_column(\App\Enums\Nations::cases(), 'value') as $option)
                    <option
                        value="{{ $option }}"
                        @if($user->naturalness == $option)
                            selected
                        @endif
                    >
                        {{$option}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label
            for=""
            class=block
            appearance-none
            w-full bg-gray-200
            border
            border-gray-200
            text-gray-700
            py-3
            px-4
            pr-8
            rounded
            leading-tight
            focus:outline-none
            focus:bg-white
            focus:border-gray-500"
            id="grid-state">Gender</label>
            <select name="gender" class="form-select" required>
                @foreach(array_column(\App\Enums\Gender::cases(), 'value') as $option)
                    <option
                        value="{{ $option }}"
                        @if($user->gender == $option)
                            selected
                        @endif
                    >
                        {{$option}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label
            for=""
            class=block
            appearance-none
            w-full bg-gray-200
            border
            border-gray-200
            text-gray-700
            py-3
            px-4
            pr-8
            rounded
            leading-tight
            focus:outline-none
            focus:bg-white
            focus:border-gray-500"
            id="grid-state">Marital Status</label>
            <select name="maritalStatus" class="form-select" required>
                @foreach(array_column(\App\Enums\MaritalStatus::cases(), 'value') as $option)
                    <option
                        value="{{ $option }}"
                        @if($user->maritalStatus == $option)
                            selected
                        @endif
                    >
                        {{$option}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4 relative">
        <x-input-label for="photo" :value="__('Photo')" />
        <input
        type="file"
        name="photo"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        />
        </div>

        <div class="mt-4">
            <a href="">Contatos ({{ $user->contacts->count() }})</a>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script type="text/javascript" src="js/select2.js"></script>
