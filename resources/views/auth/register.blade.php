<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
{{-- @dd(rand(1,1000) . '@com') --}}
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Initials -->
        <div class="mt-4">
            <x-input-label for="initials" :value="__('Initials')" />
            <x-text-input
                id="initials"
                class="block mt-1 w-full"
                type="text"
                name="initials"
                :value="old('initials')"
                required
                autofocus
                autocomplete="intials"
            />
            <x-input-error :messages="$errors->get('initials')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="birth" :value="__('birth')" />
            <x-text-input
                id="birth"
                class="block mt-1 w-full"
                type="date"
                name="birth"
                :value="old('birth')"
                required
                autofocus
                autocomplete="birth"
            />
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="nationality" :value="__('Nationality')" />
            <x-text-input
                id="nationality"
                class="block mt-1 w-full"
                type="text"
                name="nationality"
                :value="old('nationality')"
                required
                autofocus
                autocomplete="nationality"
            />
            <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="naturalness" :value="__('Naturalness')" />
            <x-text-input
                id="naturalness"
                class="block mt-1 w-full"
                type="text"
                name="naturalness"
                :value="old('naturalness')"
                required
                autofocus
                autocomplete="naturalness"
            />
            <x-input-error :messages="$errors->get('naturalness')" class="mt-2" />
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
                id="grid-state">Type Sex</label>
                <select name="gender" class="form-select" required>
                    @foreach(array_column(\App\Enums\Gender::cases(), 'value') as $option)
                        <option
                            value="{{$option}}">{{$option}}
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
                            value="{{$option}}">{{$option}}
                        </option>
                    @endforeach
                </select>
        </div>

        <!-- Photo -->
        <div class="mt-4 relative">
            <x-input-label for="photo" :value="__('photo')" />
            <input
            type="file"
            name="photo"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            />

        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
