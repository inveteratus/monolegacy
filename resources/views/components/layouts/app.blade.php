<x-acme.html class="app">
    <header>
        <nav>
            <div>
                @auth
                    <a href="{{ route('home') }}">{{ config('app.name') }}</a>
                    <a href="{{ route('explore') }}">Explore</a>
                @else
                    <a href="{{ route('index') }}">{{ config('app.name') }}</a>
                @endauth
            </div>
            <div>
                @auth
                    <div x-data="{open:false}">
                        <button type="button" @click="open=!open">
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <div x-cloak x-show="open" @click.outside="open=false">
                            <a href="#">Link</a>
                            <a href="#">Long Link</a>
                            <a href="#">Very Long Link</a>
                            <hr />
                            <x-acme.form :action="route('logout')">
                                <button type="submit">Logout</button>
                            </x-acme.form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    @auth
        <div class="outer">
            <div class="aside">
                @include('partials.sidebar')
            </div>
            <div class="inner">
                {{ $slot }}
            </div>
        </div>
    @else
        {{ $slot }}
    @endif

    <x-acme.notify :text="session('status')" />
</x-acme.html>
