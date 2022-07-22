 @if ($values)
     <div {{ $attributes->whereDoesntStartWith('values')->merge(['class' => 'type-label']) }}>
         [{{ implode(' • ', $values) }}]
     </div>
 @endif
