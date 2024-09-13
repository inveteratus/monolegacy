@props(['label' => 'Submit'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'acme-button-submit']) }}>{{ strlen($slot) ? $slot : $label }}</button>
