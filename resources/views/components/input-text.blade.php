<label for="">{{$label}}</label>
<x-text-input
    id="{{$label}}"
    class="block mt-1 w-full"
    type="text"
    name="{{$label}}"
    :value="old('{{$label}}')"
    required
    autofocus
    autocomplete="intials"
/>
