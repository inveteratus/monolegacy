<x-layouts.app>

    <main class="auth">

        <x-form>
            <p>Let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <x-input.email autofocus required autocomplete="email" :value="old('email')" />
            <footer>
                <x-button.submit label="Send Email" />
                <x-button.cancel label="Cancel" :href="route('login')" />
            </footer>
        </x-form>
    </main>

</x-layouts.app>
