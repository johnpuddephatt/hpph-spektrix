{{-- prettier-ignore-start --}}
{{ $instance->start->format('H:i') }}
@if ($instance->special_event)
<span
style="text-transform: uppercase; line-height: 1.1;  border-radius: 5px; font-weight: 700; background-color: #f8f7ef; padding: 1px 4px 0;font-size: 10px; display: inline-block">
{{ $instance->special_event }}
</span>
@endif
@if ($instance->captioned)
@include('emails.components.accessibility_icon', [
'label' => 'Captioned',
'abbreviation' => 'C',
])@endif
@if ($instance->audio_described)
@include('emails.components.accessibility_icon', [
'label' => 'Audio Description',
'abbreviation' => 'AD',
])
@endif
@if ($instance->autism_friendly)
@include('emails.components.accessibility_icon', [
'label' => 'Autism-friendly',
'abbreviation' => 'Autism',
])
@endif
@if ($instance->toddler_friendly)
@include('emails.components.accessibility_icon', [
'label' => 'Toddler-friendly',
'abbreviation' => 'Toddler',
])
@endif
@if ($instance->signed_bsl)
@include('emails.components.accessibility_icon', [
'label' => 'Signed in British Sign Language',
'abbreviation' => 'BSL',
])
@endif
@if ($instance->strand_name == 'Bring Your Own Baby')
<span title="Bring Your Own Baby"
style="text-transform: uppercase; line-height: 1.1;  border-radius: 4px; font-weight: 700; background-color: #45cdff;   padding: 1px 4px 0; font-size: 11px; display: inline-block">
BYOB
</span>
@endif
{{-- prettier-ignore-end --}}
