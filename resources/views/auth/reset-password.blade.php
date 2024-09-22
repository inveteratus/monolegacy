<x-layouts.app>

    <main class="auth">

        <x-acme.form :action="route('password.reset.store')">
            <x-acme.input.email required autocomplete="email" :value="old('email', request()->email)" />
            <x-acme.input.password autofocus required autocomplete="new-password" />
            <input type="hidden" name="token" value="{{ request()->route('token') }}" />
            <footer>
                <x-acme.button.submit label="Reset Password" />
            </footer>
        </x-acme.form>
    </main>

</x-layouts.app>
