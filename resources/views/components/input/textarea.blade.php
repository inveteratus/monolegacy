@props(['name', 'label' => null, 'value' => ''])

<x-input :name="$name" :label="$label" component="textarea">
    <textarea :id="$id('input')" name="{{ $name }}" {{ $attributes }}>{{ $value }}</textarea>
</x-input>
