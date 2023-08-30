<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    @vite(['resources/css/app.css'])
</head>

<body class="flex items-center justify-center min-h-screen">
    <div class="bg-black w-[1200px] h-[630px] text-white p-12 border-yellow border-[16px]">
        <h1 class="font-bold text-[90px] text-yellow leading-none">{!! explode(' - ', $title)[0] !!}</h1>
        @if (isset($subtitle))
            <h2 class="mt-6 text-[50px] font-bold text-sand uppercase">{{ $subtitle }}</h2>
        @endif
        @if (isset($button))
            <div class="rounded-lg inline-block px-6 py-3 mt-10 text-[30px] font-bold text-white bg-[#fe8185]">
                {{ $button }}
            </div>
        @endif
    </div>
</body>

</html>
