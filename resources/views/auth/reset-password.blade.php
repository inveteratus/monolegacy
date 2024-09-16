<x-layouts.app>

    <main class="auth">

        <x-form :action="route('password.reset.store')">
            <x-input.email required autocomplete="email" :value="old('email', request()->email)" />
            <x-input.password autofocus required autocomplete="new-password" />
            <input type="hidden" name="token" value="{{ request()->route('token') }}" />
            <footer>
                <x-button.submit label="Reset Password" />
            </footer>
        </x-form>
    </main>

</x-layouts.app>
