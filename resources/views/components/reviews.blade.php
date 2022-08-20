  @if ($reviews->count())
      <div class="relative bg-yellow text-center" x-data="{ click: false, activeSlide: 0 }"
          x-effect="if(click) { $refs[activeSlide].parentNode.scrollLeft = $refs[activeSlide].offsetLeft}; click = false;">
          <div
              class="flex w-full snap-x snap-mandatory flex-row overflow-x-auto scroll-smooth py-32 transition duration-1000 scrollbar-hide">
              @foreach ($reviews as $review)
                  <div class="w-full flex-shrink-0 transform snap-center opacity-0 transition duration-1000"
                      :class="activeSlide == {{ $loop->index }} ? 'opacity-100  delay-300' : ''"
                      x-ref="{{ $loop->index }}" x-intersect:enter.half="activeSlide = {{ $loop->index }}">
                      <div class="container mx-auto max-w-5xl">
                          <div class="type-h3 mb-8">
                              <div class="mb-8 flex flex-row justify-center gap-1">
                                  @foreach (range(0, $review['rating']) as $rating)
                                      @svg('star')
                                  @endforeach
                              </div>
                              <blockquote>
                                  <p class="type-h3 mx-auto mb-8">
                                      “{{ $review['quote'] }}”</p>
                                  @if (isset($review['publication_name']))
                                      <cite class="type-large font-bold not-italic">{{ $review['publication_name'] }}
                                          @if (isset($review['url']))
                                              <a target="_blank" class="font-normal underline"
                                                  href="{{ $review['url'] }}">read more</a>
                                          @endif
                                      </cite>
                                  @endif
                              </blockquote>
                          </div>
                      </div>
                  </div>
              @endforeach
          </div>
          <div class="absolute bottom-8 left-1/2 -translate-x-1/2 transform space-x-4">
              @foreach ($reviews as $review)
                  <button
                      class="h-2.5 w-2.5 overflow-hidden rounded-full border border-black indent-[-9999px] transition-colors duration-200 ease-out hover:bg-black hover:shadow-lg"
                      :class="{
                          'bg-black': activeSlide === {{ $loop->index }},
                          'bg-transparent': activeSlide !== {{ $loop->index }}
                      }"
                      x-on:click="click = true; activeSlide = {{ $loop->index }}">Show quote
                      {{ $loop->index + 1 }}</button>
              @endforeach
          </div>
      </div>
  @endif
