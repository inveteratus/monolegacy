@props(['name', 'label' => null, 'value' => ''])

<x-acme.input :name="$name" :label="$label" component="textarea">
    <textarea :id="$id('input')" name="{{ $name }}" {{ $attributes }}>{{ $value }}</textarea>
</x-acme.input>
