<div x-init="$dispatch('eventcount', { number: {{ $filtered ? $instances->count() : 0 }}, })">
    <x-instances :instances="$instances" :options="$options" :dark="$dark" />

    @if(method_exists($instances, 'links'))
    {{ $instances->links() }}
    @endif

</div>
