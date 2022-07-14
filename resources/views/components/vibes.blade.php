 @if ($vibes)
     <div {{ $attributes->whereDoesntStartWith('vibes')->merge(['class' => 'type-label']) }}>
         [{{ implode(' • ', $vibes) }}]
     </div>
 @endif
