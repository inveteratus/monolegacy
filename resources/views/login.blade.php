<x-layouts.app>

    <main class="auth">
        <x-form>
            <x-input.email :value="old('email')" autofocus required autocomplete="email" />
            <x-input.password required autocomplete="current-password" />
            <div>
                <x-button.submit label="Login" />
                <a href="#">Forgot your password ?</a>
            </div>
        </x-form>
        <p>
            <a href="{{ route('register') }}">Don't have an account yet ?</a>
        </p>
    </main>

</x-layouts.app>
