    <div id="{{ $layout->menuAnchor() }}"
        class="@if ($dark) bg-black text-white @endif grid container scroll-mt-24 lg:grid-cols-2 py-16">

        <h3 class="type-regular @if ($dark) text-yellow @endif py-6"
            @if ($dark) style="color: @yield('color')" @endif>
            {{ $layout->title }}</h3>

        <div class=""  x-data="{ open: null}" x-init="open =  window.location.hash.replace('#', '') ">
            @foreach ($layout->faqs as $faq)
                @include('blocks.single-faq', ['layout' => $faq, 'dark' => $dark ?? false])
            @endforeach
        </div>
    </div>
