@props(['text' => null, 'timeout' => 5000])

@if ($text)
    <div class="component-notify" x-data="{open:true,init(){setTimeout(()=>this.open=false,{{ $timeout }})}}" x-show="open">
        <p>{{ $text }}</p>
        <button type="button" @click.prevent.stop="open=false">
            <x-icon.x-mark />
        </button>
    </div>
@endif
