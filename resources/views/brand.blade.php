@extends('layouts.default')

@section('content')
    <div class="container">
        @svg('loading', 'w-64')
        <h1 class="type-large mt-32 mb-32">Colour</h1>

        <div class="aspect-square w-1/4 border border-gray bg-yellow"></div>

        <div class="mt-8 w-full">
            <div class="flex flex-row gap-8">
                <div class="aspect-square w-1/3 border border-gray bg-black"></div>

                <div class="aspect-square w-1/3 border border-gray bg-gray-dark"></div>
                <div class="aspect-square w-1/3 border border-gray bg-gray-medium"></div>

                <div class="aspect-square w-1/3 border border-gray bg-gray-light"></div>
                <div class="aspect-square w-1/3 border border-gray bg-gray"></div>
                <div class="aspect-square w-1/3 border border-gray"></div>

            </div>
        </div>

        <h1 class="type-large mt-32">Typography</h1>
        <div class="space-between mt-32 mb-32 flex flex-col lg:flex-row">
            <div class="space-y-8 lg:w-1/2">
                <div>
                    <div class="type-large bg-gray py-4">
                        Guardians
                        of
                        the Galaxy Vol. 3
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">H1</span> PT 70/65 (-50)</div>
                </div>

                <div>
                    <div class="type-medium bg-gray py-4">
                        Guardians
                        of
                        the Galaxy Vol. 3
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">H2</span> PT 60/62 (-50)</div>
                </div>

                <div>
                    <div class="type-regular bg-gray py-4">
                        Guardians
                        of
                        the Galaxy Vol. 3
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">H3</span> PT 50/52 (-40)</div>
                </div>

                <div>
                    <div class="type-medium bg-gray py-4">
                        Guardians
                        of
                        the <br> Galaxy Vol. 3
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">H4</span> PT 30/35 (-35)</div>
                </div>

            </div>
            <div class="space-y-8 lg:ml-auto lg:w-1/4">

                <div>
                    <div class="bg-gray py-2">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Body copy</span> PT 16/20 (-15)</div>
                </div>

                <div>
                    <div class="type-regular bg-gray">
                        Consectetur <br>adipisicing elit.
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Subtitle +</span> PT 20/24 (-25)</div>
                </div>

                <div>
                    <div class="type-regular-copy bg-gray py-2">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Subtitle copy +</span> PT 20/24 (-15)
                    </div>
                </div>

                <div>
                    <div class="type-large bg-gray py-2">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Body copy +</span> PT 20/26 (-15)</div>
                </div>

                <div>
                    <div class="@apply type-xs-mono bg-gray py-2">
                        Journal
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Label</span> CAPS PT 12/14 (+30)</div>
                </div>

                <div>
                    <div class="type-xs-mono bg-gray py-2">
                        Lorem ipsum dolor sit<br> amet
                    </div>
                    <div class="mt-2 font-mono"><span class="font-sans font-bold">Annotation</span> PT 15/18 (-15)</div>
                </div>
            </div>
        </div>
    @endsection
