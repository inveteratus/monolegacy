<x-layouts.app>

    <main class="auth">
        <x-form>
            <x-input.text name="name" :value="old('name')" autofocus required autocomplete="name" />
            <x-input.email :value="old('email')" required autocomplete="email" />
            <x-input.password required autocomplete="current-password" />
            <div>
                <x-button.submit label="Register" />
            </div>
        </x-form>
        <p>
            <a href="{{ route('login') }}">Already have an account ?</a>
        </p>
    </main>

</x-layouts.app>
