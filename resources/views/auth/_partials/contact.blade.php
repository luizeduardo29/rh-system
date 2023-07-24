<div class="border-b border-gray-900/10 pb-12 pt-6">
    @csrf
    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>

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
        <select name="contacts[XXXXXXXXXXXXX][typeContact]" class="form-select" required>
            @foreach(array_column(\App\Enums\TypeContact::cases(), 'value') as $option)
                <option
                    value="{{$option}}">{{$option}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="contacts[XXXXXXXXXXXXX][info]" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>
