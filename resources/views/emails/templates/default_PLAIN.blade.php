@if ($email->title)
{{ $email->title }}
@endif
Showing from {{ $email->date->format('D d M') }}


@if (is_iterable($email->content))
@foreach ($email->content as $section)
@include('emails.sections.' . $section->name() . '_PLAIN', ['section' => $section])
@endforeach
@endif

@if ($email->settings['faqs'])


Frequently Asked Questions

@foreach ($settings['email_faqs'] as $faq)
{!! $faq['question'] !!}

{!! Str::of($faq['answer'])->stripTags() !!}

@endforeach

@endif

@if ($email->settings['social'])
Find us on social media

Facebook: {{ $settings['facebook'] }}
Twitter: {{ $settings['twitter'] }}
Instagram: {{ $settings['instagram'] }}
@endif



Copyright Hyde Park Picture House {{ date('Y') }}
@if (isset($settings['charity_number']))
Registered Charity No.{{ $settings['charity_number'] }}
@endif
Address: {{ $settings['address'] }}
Email: info@hpph.co.uk

https://$UNSUB$
