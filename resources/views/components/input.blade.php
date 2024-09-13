@props(['name', 'label' => null])

<div x-data x-id="['input']" class="input">
    <label :for="$id('input')">{{ $label ?? str($name)->title() }}</label>
    <div>
        {{ $slot }}
        @error($name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
</div>
