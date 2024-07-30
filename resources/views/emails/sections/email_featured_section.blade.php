@php

$film = \App\Models\Event::withoutGlobalScopes()

    ->with([
        'instances' => function (\Illuminate\Contracts\Database\Eloquent\Builder $query) use ($email) {
            $query->where('start', '>=', $email->date)->where('start', '<=', $email->date->copy()->addDays(7));
        },
    ])
    ->find($section->event);

@endphp

<mj-wrapper background-color="#000000" full-width="full-width">
    <mj-hero full-width="full-width" css-class="film-row-hero" border-radius="5px" vertical-align="bottom"
        mode="fluid-height" background-width="1200px" background-height="720px"
        background-url="{{ $film->featuredImage?->getUrl('wide') ?? 'https://cloud.githubusercontent.com/assets/1830348/15354890/1442159a-1cf0-11e6-92b1-b861dadf1750.jpg' }}"
        background-color="#2a3448" padding="0px 0px">
        <mj-section padding="15px 0 0" background-color="#333">
            <mj-text font-size="20px" color="#fff" line-height="1.2" font-weight="700">{{ $film->name }}</mj-text>
        </mj-section>
    </mj-hero>
</mj-wrapper>
