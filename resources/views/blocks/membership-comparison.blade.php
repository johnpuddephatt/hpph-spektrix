@push('webComponents', '#spektrix-memberships')

<div class="bg-black py-20 container px-4 text-white text-center">
    <div class="mt-8 grid lg:grid-cols-3 gap-16 lg:gap-4">
        @foreach ($layout->memberships as $membership)
            @php($membership = $membership->membership)

            <div class="flex flex-col">
                <div class="relative min-h-[14rem] flex flex-col justify-center">
                    @if ($membership->image)
                        <img src="{{ Storage::url($membership->image) }}"
                            class="w-full inset-0 h-full opacity-60 absolute block object-cover object-center" />
                    @endif
                    <img src="{{ Storage::url($membership->logo) }}" class="relative w-32 block h-auto mx-auto" />
                </div>
                <div class="type-xs-mono text-white relative mt-2 mb-6 max-w-xs mx-auto">
                    {{ $membership->description }}
                </div>
                <div class="bg-yellow text-center py-6 text-black">
                    <span class="type-medium">{{ $membership->price }}</span><span
                        class="type-regular !font-normal">&nbsp;/&nbsp;year</span>
                </div>
                <ul class="flex-grow bg-sand">
                    @foreach ($membership->benefits as $benefit)
                        <li
                            class="type-xs-mono {{ $loop->even ? '' : 'bg-sand-dark' }} text-black text-center py-3 lg:py-8">
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>

                <spektrix-memberships class="relative" client-name="{{ $settings['spektrix_client_name'] }}"
                    custom-domain="{{ $settings['spektrix_custom_domain'] }}" membership-id="{{ $membership->id }}">

                    <button
                        class="type-regular w-full bg-yellow text-center py-6 text-black hover:bg-opacity-90 transition"
                        data-submit-membership>Add to basket</button>

                    <a href="{{ \App\Models\Page::getTemplateUrl('gift-membership-page') . '?selected=' . $membership->id }}"
                        class="type-regular block w-full border-yellow-dark border-2 text-yellow-dark text-center py-6 mt-1 hover:bg-opacity-90 transition">Gift
                        this membership</a>

                    <div class="type-regular absolute text-yellow leading-tight py-6 px-6 inset-0 bg-black text-center"
                        data-success-container style="display: none;">Added to basket</div>
                    <div class="absolute text-yellow font-bold inset-0 leading-tight py-4 px-6 bg-black text-center"
                        data-fail-container style="display: none;">Something went wrong.</div>
                </spektrix-memberships>

            </div>
        @endforeach

    </div>
</div>
