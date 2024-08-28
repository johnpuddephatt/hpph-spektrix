    {{-- prettier-ignore-start --}}
<mj-wrapper background-color="#000000" full-width="full-width">
<mj-section padding="25px 0">

<mj-image  href="{{ $section->url }}" src="{{ Storage::disk('digitalocean')->url($section->image) }}" alt="{{ $section->title }}" width="600px" padding="0px"></mj-image>
</mj-section>
</mj-wrapper>
{{-- prettier-ignore-end --}}
