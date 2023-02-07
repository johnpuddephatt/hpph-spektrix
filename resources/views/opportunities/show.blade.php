@extends('layouts.default', ['edit_link' => route('nova.pages.edit', ['resource' => 'opportunities', 'resourceId' => $opportunity->id])])
@section('title', 'Opportunities')
@section('content')
    <div class="lg:flex lg:flex-row">
        <div class="fixed top-0 left-0 -z-10 h-24 w-full bg-sand lg:w-1/2"></div>
        <div class="container flex min-h-screen flex-col items-start bg-sand pt-24 lg:w-1/2">

            <h1 class="type-large max-w-md">{{ $opportunity->title }}</h1>
            <div class="mt-2">{{ $opportunity->type }}
                @if ($opportunity->application_deadline)
                    &middot;
                @endif
                {{ $opportunity->application_deadline }}
            </div>

            <a class="sticky bottom-4 mt-auto mb-4 inline-block rounded border border-black py-1 pl-0 pr-2 uppercase"
                href="#">@svg('chevron-right', ' align-bottom h-6 w-6 inline-block transform rotate-180 origin-center')
                Back</a>
        </div>
        <div class="container pt-24 lg:w-1/2">
            <div class="type-medium mb-16 max-w-xl">{{ $opportunity->summary }}</div>

            <table class="w-full max-w-xl table-fixed border-b border-gray-light">
                @if ($opportunity->salary)
                    <tr>
                        <td class="w-2/5 py-4 pr-4 align-top font-bold">Pay</td>
                        <td class="py-4 align-top">{{ $opportunity->salary }}
                        </td>
                    </tr>
                @endif

                @if ($opportunity->hours)
                    <tr>
                        <td class="w-2/5 py-4 pr-4 align-top font-bold">Hours</td>
                        <td class="py-4 align-top">{{ $opportunity->hours }}
                        </td>
                    </tr>
                @endif

                @if ($opportunity->responsible_to)
                    <tr>
                        <td class="w-2/5 py-4 pr-4 align-top font-bold">Responsible to</td>
                        <td class="py-4 align-top">{{ $opportunity->responsible_to }}
                        </td>
                    </tr>
                @endif

                @if ($opportunity->probation_period)
                    <tr>
                        <td class="w-2/5 py-4 pr-4 align-top font-bold">Probation period</td>
                        <td class="py-4 align-top">{{ $opportunity->probation_period }}
                        </td>
                    </tr>
                @endif

                @if ($opportunity->notice_period)
                    <tr>
                        <td class="w-2/5 py-4 pr-4 align-top font-bold">Notice period</td>
                        <td class="py-4 align-top">{{ $opportunity->notice_period }}
                        </td>
                    </tr>
                @endif

                @if ($opportunity->holidays)
                    <tr>
                        <td class="w-2/5 py-4 pb-12 pr-4 align-top font-bold">Holidays</td>
                        <td class="py-4 pb-12 align-top">{{ $opportunity->holidays }}
                        </td>
                    </tr>
                @endif

            </table>

            <div class="-mx-4 -mt-12 max-w-xl md:-mx-6 lg:-mx-8">
                @include('components.editorjs', ['content' => $opportunity->content])
            </div>
        </div>
    </div>
@endsection
