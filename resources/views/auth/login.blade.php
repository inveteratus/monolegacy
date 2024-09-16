<x-layouts.app>

    <main class="auth">
        <x-form>
            <x-input.email :value="old('email')" autofocus required autocomplete="email" />
            <x-input.password required autocomplete="current-password" />
            <footer>
                <x-button.submit label="Login" />
                @if (Route::has('password.recover'))
                    <a href="{{ route('password.recover') }}">Forgot your password ?</a>
                @endif
            </footer>
        </x-form>
        @if (Route::has('register'))
            <p>
                <a href="{{ route('register') }}">Don't have an account yet ?</a>
            </p>
        @endif
    </main>

</x-layouts.app>
