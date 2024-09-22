@props(['name', 'label' => null, 'value' => ''])

<x-acme.input :name="$name" :label="$label" component="text">
    <input :id="$id('input')" type="text" name="{{ $name }}" value="{{ $value }}" {{ $attributes }} />
</x-acme.input>
