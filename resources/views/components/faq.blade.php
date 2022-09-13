@if ($more_information->enabled ?? false)
    <div class="flex-row gap-8 bg-white lg:flex">
        <div class="relative bg-gray lg:sticky lg:top-0 lg:max-h-screen lg:min-h-[30rem] lg:w-1/2">
            <h3 class="type-subtitle absolute left-4 top-4 lg:left-8 lg:top-8" style="color: {{ $strand->color }}">
                {{ $more_information->title }}</h3>
            {!! $strand->getMedia('content->more_information->image')->first()->img('square', ['class' => 'h-full object-cover object-center w-full'])->toHtml() !!}
        </div>
        <div class="-mt-12 flex items-center lg:container lg:mt-0 lg:w-1/2 lg:py-8">
            <div class="prose max-w-xl">
                @include('components.editorjs', ['content' => json_decode($more_information->content)])
            </div>
        </div>
    </div>
@endif
