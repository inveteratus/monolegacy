@props(['name', 'label' => null, 'component'])

<div x-data x-id="['input']" class="component-input-{{ $component }}">
    <label :for="$id('input')">{{ $label ?? str($name)->title() }}</label>
    <div>
        {{ $slot }}
        @error($name)
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
</div>
