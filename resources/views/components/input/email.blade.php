@props(['name' => 'email', 'label' => null, 'value' => ''])

<x-input :name="$name" :label="$label" component="email">
    <input :id="$id('input')" type="email" name="{{ $name }}" value="{{ $value }}" {{ $attributes }} />
</x-input>
