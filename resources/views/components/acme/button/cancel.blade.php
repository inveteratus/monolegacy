@props(['href', 'label' => 'Cancel'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'acme-button-cancel']) }}>{{ strlen($slot) ? $slot : $label }}</a>
