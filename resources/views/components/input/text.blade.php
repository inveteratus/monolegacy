@props(['name', 'label' => null, 'value' => ''])

<x-input :name="$name" :label="$label">
    <input :id="$id('input')" type="text" name="{{ $name }}" value="{{ $value }}" {{ $attributes }} />
</x-input>
