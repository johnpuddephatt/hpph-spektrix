@extends('layouts.default', ['header_position' => 'absolute', 'edit_link' => route('nova.pages.edit', ['resource' => 'pages', 'resourceId' => $page['id']])])

@section('title', $page->name)
@section('description', $page->introduction)

@push('webComponents', '#spektrix-donate')

@section('content')
    @include('sections.pageheader-default')

    <div class="mb-16">
        @foreach ($page->content as $group)
            <div class="mb-8 bg-yellow">
                <h2 class="type-h3 container py-4">
                    {{ $group->attributes->fund_group_title }}
                </h2>
            </div>

            <div class="container grid grid-cols-2 gap-4">

                @foreach ($group->attributes->funds as $fund)
                    <div>
                        @php $fund = \App\Models\Fund::find($fund) @endphp

                        @if ($fund->getMedia('main')->first())
                            {!! $fund->getMedia('main')->first()->img('landscape', ['class' => 'rounded mb-4'])->toHtml() !!}
                        @endif
                        <h3 class="type-h5 mb-4">{{ $fund->name }}</h3>
                        <div class="mb-4 max-w-xl">{{ $fund->description }}</div>
                        <spektrix-donate client-name="{{ $settings['spektrix_client_name'] }}"
                            custom-domain="{{ $settings['spektrix_custom_domain'] }}" fund-id="{{ $fund->id }}">
                            <input value="20" class="inline-block rounded border border-black py-2 px-4" type="text"
                                data-custom-donation-input>
                            <button class="type-subtitle rounded bg-yellow py-2 px-8" data-submit-donation>Add to
                                basket</button>
                            <div data-success-container style="display: none;">Donation added to basket</div>
                            <div data-fail-container style="display: none;">Donation could not be added to basket</div>
                        </spektrix-donate>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
