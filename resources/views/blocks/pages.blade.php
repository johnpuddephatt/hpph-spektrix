@if ($layout->child_pages)
    <div class="bg-black text-white py-8 pb-16">
        <div class="flex flex-col lg:flex-row justify-center">
            @foreach ($layout->child_pages as $child)
                @if ($child->page)
                    <a class="group w-full lg:w-1/2 relative block bg-black-light" href="{{ $child->page->url }}">
                        {!! $child->page->mainImage?->img('landscape')->attributes([
                            'class' =>
                                'aspect-square object-cover lg:aspect-auto max-w-none w-full opacity-60 transition group-hover:opacity-90',
                        ]) !!}

                        <div class="p-4 inset-0 absolute text-center items-center justify-center flex flex-col">

                            <div class="my-auto pt-16 transition group-hover:-translate-y-4">
                                <h3 class="type-medium">{{ $child->page->name }}</h3>
                                @svg('arrow-right', 'text-white group-hover:text-black -rotate-45 h-10 w-10 block rounded-full bg-black bg-opacity-50  group-hover:bg-opacity-100 group-hover:bg-yellow p-2 mt-4 text-black mx-auto transition')
                            </div>
                        </div>
                    </a>
                @else
                    <a class="group w-full lg:w-1/2 relative block bg-black-light" href="{{ $child->url }}"
                        target="_blank">
                        <img src="{{ Storage::url($child->image) }}"
                            class="aspect-square lg:aspect-auto object-cover max-w-none w-full opacity-60 transition group-hover:opacity-90" />

                        <div class="p-4 inset-0 absolute text-center items-center justify-center flex flex-col">

                            <div class="my-auto pt-16 transition group-hover:-translate-y-4">
                                <h3 class="type-medium">{{ $child->title }}</h3>
                                @svg('arrow-right', 'text-white group-hover:text-black -rotate-45 h-10 w-10 block rounded-full bg-black bg-opacity-50  group-hover:bg-opacity-100 group-hover:bg-yellow p-2 mt-4 text-black mx-auto transition')
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endif
