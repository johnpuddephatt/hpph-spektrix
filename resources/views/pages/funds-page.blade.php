@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@section('content')
    @webComponent('spektrix-donate')
    @include('components.pageheader-default')

    <div class="mb-16">
        @foreach ($page->content as $group)
            <div class="mb-8 bg-yellow">
                <h2 class="type-h3 container py-4">
                    {{ $group->attributes->fund_group_title }}
                </h2>
            </div>

            <div>
                @foreach ($group->attributes->funds as $fund)
                    @php $fund = \App\Models\Fund::find($fund) @endphp
                    <h3>{{ $fund->name }}</h3>
                    <spektrix-donate client-name="{{ $settings['spektrix_client_name'] }}"
                        custom-domain="{{ $settings['spektrix_custom_domain'] }}" fund-id="{{ $fund->id }}">
                        <span>Amount you are donating: £</span><span data-display-donation-amount></span>
                        <button data-donate-amount="10">£10</button>
                        <button data-donate-amount="20">£20</button>
                        <button data-donate-amount="30">£30</button>
                        <button data-donate-amount="0.001">0.001</button>
                        <button data-submit-donation>Donate</button>
                        <button data-clear-donation>Clear Donation</button>
                        <div data-success-container style="display: none;">Insert success content/markup here</div>
                        <div data-fail-container style="display: none;">Insert failure content/markup here</div>
                    </spektrix-donate>
                @endforeach
            </div>
    </div>
    @endforeach
    </div>
@endsection
