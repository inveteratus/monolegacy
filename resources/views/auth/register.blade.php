<x-layouts.app>

    <main class="auth">
        <x-acme.form>
            <x-acme.input.text name="name" :value="old('name')" autofocus required autocomplete="name" />
            <x-acme.input.email :value="old('email')" required autocomplete="email" />
            <x-acme.input.password required autocomplete="new-password" />
            <footer>
                <x-acme.button.submit label="Register" />
            </footer>
        </x-acme.form>
        <p>
            <a href="{{ route('login') }}">Already have an account ?</a>
        </p>
    </main>

</x-layouts.app>
