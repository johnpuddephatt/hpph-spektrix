<div x-init="$dispatch('eventcount', { number: {{ $filtered ? $instances->count() : 0 }}, })">
    <x-instances :instances="$instances" :options="$options" :dark="$dark" />
    {{ $instances->links() }}

</div>
