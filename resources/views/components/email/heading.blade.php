@php
$arr = match ($type) {
    "small" => [
        'font-size' => 14,
        'font-weight' => 400,
        'line-height' => 17,
        'letter-spacing' => -0.225
    ],
    "regular" => [
        'font-size' => 20,
        'font-weight' => 700,
        'line-height' => 24,
        'letter-spacing' => -0.4
    ],
    "medium" => [
        'font-size' => 30,
        'font-weight' => 700,
        'line-height' => 35,
        'letter-spacing' => -0.9
    ],
    "xs-mono" => [
        'font-size' => 12,
        'font-weight' => 400,
        'line-height' => 16,
        'font-family' => 'BasisGrotesqueMono',
        'text-transform' => 'uppercase',
        'letter-spacing' => -0.15


    ],
    default => [
        'font-size' => 12,
        'font-weight' => 400
    ],
}
@endphp

<mj-text 
    
    padding="{{$padding ?? 0}}"
    font-size="{{ $arr['font-size']}}px"
    font-weight="{{ $arr['font-weight']}}" 
    align="{{ $align ?? 'left' }}"
    color="{{ $color ?? 'inherit'}}"
    font-family="{{ $arr['font-family'] ?? 'BasisGrotesque'}}" 
    text-transform="{{ $arr['text-transform'] ?? ''}}"
    line-height="{{ isset($arr['line-height']) ? ($arr['line-height'] . 'px') : 1  }}" 
    letter-spacing="{{ $arr['letter-spacing'] ?? 0  }}px">
[{{ $type }}]
{!! $slot !!}
</mj-text>