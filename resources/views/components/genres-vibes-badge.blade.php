 @if ($values)
     <div {{ $attributes->whereDoesntStartWith('values')->merge(['class' => 'type-label']) }}>
         [{!! implode('&thinsp;•&thinsp;', $values) !!}]
     </div>
 @endif
