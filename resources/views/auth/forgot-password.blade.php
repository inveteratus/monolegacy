<x-layouts.app>

    <main class="auth">

        <x-acme.form>
            <p>Let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <x-acme.input.email autofocus required autocomplete="email" :value="old('email')" />
            <footer>
                <x-acme.button.submit label="Send Email" />
                <x-acme.button.cancel label="Cancel" :href="route('login')" />
            </footer>
        </x-acme.form>
    </main>

</x-layouts.app>
