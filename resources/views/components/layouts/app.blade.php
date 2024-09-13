<x-html class="app">
    <header>
        <nav>
            <div>
                @auth
                    <a href="{{ route('home') }}">{{ config('app.name') }}</a>
                @else
                    <a href="{{ route('index') }}">{{ config('app.name') }}</a>
                @endif
            </div>
            <div>
                @auth
                    <div x-data="{open:false}">
                        <button type="button" @click="open=!open">
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open=false"">
                            <a href="#">Link</a>
                            <a href="#">Long Link</a>
                            <a href="#">Very Long Link</a>
                            <hr />
                            <x-form :action="route('logout')">
                                <button type="submit">Logout</button>
                            </x-form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endif
            </div>
        </nav>
    </header>

    {{ $slot }}
</x-html>
