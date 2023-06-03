@if (isset($settings[$account]))
    <a title="Visit our {{ $account }} account"
        class="inline-block rounded-full bg-black p-2.5 text-white hover:text-yellow transition border border-gray-medium"
        target="_blank" href="{{ $settings[$account] }}">@svg($account, 'h-4 w-4')</a>
@endif
