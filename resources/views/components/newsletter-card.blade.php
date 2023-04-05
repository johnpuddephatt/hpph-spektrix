@if (isset(
    $settings['newsletter_image'],
    $settings['newsletter_title'],
    $settings['newsletter_message'],
    $settings['newsletter_link']))
    <div class="bg-black container py-16">
        <div class="bg-black-light rounded overflow-hidden flex flex-col lg:flex-row lg:items-center text-white">
            <div class="bg-black self-stretch relative lg:w-1/3 bg-opacity-50">
                <img class="object-cover h-full" src="{{ Storage::url($settings['newsletter_image']) }}" />
            </div>
            <div class="relative lg:py-16 lg:w-2/3 px-8 p-6 pr-16 lg:pl-[16.67%]"">
                <h3
                    class="type-xs-mono hidden lg:block text-white opacity-30 top-[45%] absolute right-full origin-bottom translate-x-full -rotate-90 transform whitespace-nowrap">
                    Newsletter</h3>
                <h3 class="type-regular lg:type-medium mb-8 !font-normal max-w-xs lg:max-w-md">{!! Str::markdown($settings['newsletter_title']) !!}
                </h3>
                <div class="type-xs lg:type-regular !font-normal text-gray-light max-w-xs lg:max-w-md">
                    {{ $settings['newsletter_message'] }}
                </div>
                <a class="type-xs-mono text-yellow max-w-lg mt-8 lg:mt-12 items-end justify-between flex flex-row gap-2"
                    href="{{ $settings['newsletter_link'] }}">

                    Sign up
                    @svg('arrow-right', 'text-white h-10 w-10 p-2.5 -rotate-45 rounded-full border border-gray-light')
                </a>

            </div>
        </div>
    </div>
@endif
