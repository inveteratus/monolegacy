@props(['href', 'label' => 'Cancel'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'component-button-cancel']) }}>{{ strlen($slot) ? $slot : $label }}</a>
