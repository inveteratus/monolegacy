<x-layouts.app>

    <h1>Home</h1>

    <x-form :action="route('logout')">
        <x-button.submit label="Logout" />
    </x-form>

</x-layouts.app>
