@extends('layouts.default', ['header_class' => 'text-black', 'edit_link' => route('nova.pages.edit', ['resource' => 'opportunities', 'resourceId' => $opportunity->id])])
@section('title', 'Opportunity: ' . $opportunity->title)
@section('description', $opportunity->summary)
@section('image', $opportunity->featuredImage?->getUrl('portrait'))

@section('menu_right')
    <a class="type-xs-mono hidden border-transparent lg:inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
        href="{{ \App\Models\Page::getTemplateUrl('opportunities-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
        Back </a>
@endsection
@section('content')
    <div class="relative">
        <div class="fixed bg-black inset-0 h-[75vh] lg:h-screen lg:w-1/2 -z-20">
            @if ($opportunity->featuredImage)
                {{ $opportunity->featuredImage->img('portrait')->attributes(['class' => 'h-full w-full opacity-80 object-cover']) }}
            @endif

        </div>

        <div class="mt-[75vh] lg:mt-0 lg:ml-[50%] min-h-screen bg-sand relative">

            <div class="bg-sand-light pt-6 pb-12 lg:h-[66.6vh] flex flex-col">
                <div class="container relative lg:hidden">
                    <a class="type-xs-mono border-transparent mb-4 inline-block uppercase border-2 pl-1 pr-4 py-2 rounded hover:border-sand"
                        href="{{ \App\Models\Page::getTemplateUrl('opportunities-page') }}">@svg('chevron-right', ' align-top h-4 w-4 inline-block transform rotate-180 origin-center')
                        Back </a>
                </div>
                <div class="container mt-auto">

                    <div class="relative">
                        <div
                            class="container top-[50vh] lg:top-auto right-0 lg:right-[50vw] lg:w-[50vw] w-screen fixed text-white -z-10">
                            <h1 class="type-medium lg:type-large max-w-md">{{ $opportunity->title }}</h1>
                            <div class="type-xs-mono mt-2">{{ $opportunity->type }}</div>
                            @if ($opportunity->application_deadline)
                                <div class="type-xs-mono">
                                    Apply by {{ $opportunity->application_deadline }}</div>
                            @endif
                        </div>
                        <div class="type-medium mb-8 max-w-xl">{{ $opportunity->summary }}</div>
                    </div>
                </div>
            </div>

            <div class="container pt-24">
                <h3 class="type-xs-mono mb-4">General:</h3>
                <table class="mb-24 w-full max-w-xl table-fixed border-b border-sand-dark">

                    @if ($opportunity->salary)
                        <x-opportunity-detail-row key="Pay" :value="$opportunity->salary" />
                    @endif

                    @if ($opportunity->hours)
                        <x-opportunity-detail-row key="Hours" :value="$opportunity->hours" />
                    @endif

                    @if ($opportunity->responsible_to)
                        <x-opportunity-detail-row key="Responsible to" :value="$opportunity->responsible_to" />
                    @endif

                    @if ($opportunity->probation_period)
                        <x-opportunity-detail-row key="Probation period" :value="$opportunity->probation_period" />
                    @endif

                    @if ($opportunity->notice_period)
                        <x-opportunity-detail-row key="Notice period" :value="$opportunity->notice_period" />
                    @endif

                    @if ($opportunity->holidays)
                        <x-opportunity-detail-row key="Holidays" :value="$opportunity->holidays" />
                    @endif

                </table>

                <div class="max-w-xl">
                    <x-editorjs class="pb-36" :content="$opportunity->content" block_class=" lg:mr-0"
                        wide_class="container lg:w-3/4 lg:mr-0" fullwidth_class="w-full" />
                </div>
            </div>
        </div>

        @if ($opportunity->application_form)
            <div class="lg:container sticky lg:fixed bottom-0 left-0">
                <a class="type-regular lg:mb-6 flex lg:inline-block flex-row items-center lg:w-auto w-full text-yellow bg-black hover:bg-black-light lg:hover:bg-yellow-dark lg:text-black lg:bg-yellow lg:rounded px-4 py-6 lg:py-4"
                    href="{{ Storage::url($opportunity->application_form) }}" download>Application
                    form <span class="type-xs-mono inline-block ml-auto lg:ml-8 !font-normal">[PDF]</span>
                    @svg('chevron-right', 'h-6 rotate rotate-90 w-6 ml-0 inline-block text-yellow lg:text-black')
                </a>

            </div>
        @endif

    </div>
@endsection
