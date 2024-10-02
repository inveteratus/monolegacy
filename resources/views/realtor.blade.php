<x-layouts.app>

    <x-title label="Realtor" :links="[
        'Explore' => route('explore'),
    ]"/>

    <main class="realtor">
        @foreach ($properties as $property)
            <a href="{{ route('realtor.details', $property) }}">
                <img src="/storage/{{ $property->image }}" />
                <p>{{ $property->name }}</p>
            </a>
        @endforeach
    </main>

</x-layouts.app>
