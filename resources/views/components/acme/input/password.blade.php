@props(['name' => 'password', 'label' => null])

<x-acme.input :name="$name" :label="$label" component="password">
    <div x-data="{visible:false}">
        <input :type="visible?'text':'password'" :id="$id('input')" name="{{ $name }}" x-ref="input" {{ $attributes }} />
        <button type="button" tabindex="-1" @click.prevent.stop="visible=!visible;$refs.input.focus()">
            <x-acme.icon.eye-slash x-show="!visible" />
            <x-acme.icon.eye x-cloak x-show="visible" />
        </button>
    </div>
</x-acme.input>
