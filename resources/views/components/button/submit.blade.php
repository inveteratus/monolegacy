@props(['label' => 'Submit'])

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'component-button-submit']) }}>{{ strlen($slot) ? $slot : $label }}</button>
