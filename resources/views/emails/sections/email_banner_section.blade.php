    {{-- prettier-ignore-start --}}
<mj-wrapper background-color="{{ $section->background ?? '#000000' }}" full-width="full-width">
<mj-section padding="25px 0">

<mj-image border-radius="5px" href="{{ $section->url }}" src="{{ Storage::disk('digitalocean')->url($section->image) }}" alt="{{ $section->title }}" width="600px" padding="0px"></mj-image>
</mj-section>
</mj-wrapper>
{{-- prettier-ignore-end --}}
