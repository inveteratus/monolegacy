<x-layouts.app>

    <x-title label="Player List" :links="[
        'Explore' => route('explore'),
    ]"/>

    <main class="players">

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $player)
                    <tr>
                        <td>{{ $player->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $players->links() }}

    </main>

</x-layouts.app>

