<x-layouts.app>

    <x-title label="National Bank" :links="[
        'Explore' => route('explore'),
    ]"/>

    <main class="bank">
        <x-acme.form>
            <div>
                <h3>Deposit</h3>
                <p><x-currency :amount="auth()->user()->cash" /><span>Available</span></p>
                <div>
                    @forelse (atm(auth()->user()->cash) as $amount)
                        <button type="submit" name="deposit" value="{{ $amount }}">{{ number_format($amount) }}</button>
                    @empty
                        <span>Insufficient Funds</span>
                    @endforelse
                </div>
                @error('deposit')
                    <span>{{ $message }}</span>
                @enderror
           </div>
            <div>
                <h3>Withdraw</h3>
                <p><x-currency :amount="auth()->user()->bank" /><span>Available</span></p>
                <div>
                    @forelse (atm(auth()->user()->bank) as $amount)
                        <button type="submit" name="withdraw" value="{{ $amount }}">{{ number_format($amount) }}</button>
                    @empty
                        <span>Insufficient Funds</span>
                    @endforelse
                </div>
                @error('withdraw')
                    <span>{{ $message }}</span>
                @enderror
            </div>
        </x-acme.form>
    </main>

</x-layouts.app>

