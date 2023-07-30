<x-app-layout>

    <section class="mt-3">
    @if($callPage === $groupedMenu)
        <div class="flex justify-between mx-1">
            <span class="text-lg lg:text-xl font-bold text-gray-700">
                Providers
            </span>

            <span class="text-xs lg:text-sm mt-1 lg:mt-0 font-semibold text-gray-700">
                {{ count($providers) }} providers
            </span>
        </div>
    @endif
    </section>

    <section>
    @foreach($providers as $provider)
        <div class="p-1 lg:p-2">
            <div class="text-base lg:text-lx font-bold text-gray-700 my-2">
                <a href="{{ $provider['provider_link'] }}">{{ $provider['name'] }}</a>
            </div>

        @foreach($provider['feeds'] as $feed)
            <div class="ml-2 lg:ml-4 text-sm lg:text-base font-semibold text-gray-700 mt-4 lg:mt-6">
                {{ $feed['title'] }}
            </div>

            <ul class="ml-3 lg:ml-5 mt-1">
            @foreach($feed['articles'] as $article)
                <li class="flex justify-items-start pt-1 pb-2 gap-3 lg:gap-4 even:bg-gray-100 odd:bg-white rounded-sm">
                    <div class="container">
                    @if($article['thumbnail'] !== $feed['logo'])
                        <div class="mt-2">
                            <img src="{{ $article['thumbnail'] }}"
                                 class="object-contain md:object-scale-down w-20 md:w-24 lg:w-28 rounded-sm"
                                 alt="{{ $article['provider'] }}"/>
                        </div>
                    @endif

                        <div class="text-sm lg:text-base font-medium lg:font-semibold mt-1">
                            <a href="{{ $article['link'] }}"
                               target="_blank">{!! html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') !!}</a>
                        </div>

                    @if(empty($article['content']))
                        @if(!empty($article['tags']))
                            <div class="mt-1">
                                <span class="text-xs lg:text-sm text-gray-700"><small>{{ $article['tags'] }}</small></span>
                            </div>
                        @endif
                    @else
                        <div class="text-xs lg:text-sm text-gray-500 mt-1">
                            {!! $article['content'] !!}
                        </div>
                    @endif
                        <div class="flex justify-between mt-2">
                            <div>
                            <span class="text-xs lg:text-sm text-gray-800">
                                <small>Published: {{ $article['published_at'] }}</small>
                            </span>
                            </div>

                            <form action="{{ route('article.update', $article['id']) }}" method="post">
                                @csrf

                            @if(!empty($providerId))
                                <input type="hidden" name="provider_id" value="{{ $providerId }}">
                            @endif

                                <input type="hidden" name="page" value="{{ $callPage }}">
                                <button type="submit"
                                    title="Mark as read"
                                    class="text-white
                                        bg-sky-500
                                        hover:bg-sky-700
                                        focus:ring-4
                                        focus:ring-sky-300
                                        rounded
                                        px-1
                                        lg:px-2
                                        py-0.5
                                        lg:py-1
                                        mr-1
                                        mb-1
                                        focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 lg:w-5 h-4 lg:h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </form>

                        </div>

                    </div>
                </li>
            @endforeach
            </ul>
        @endforeach

            <hr class="mt-4">

        </div>
    @endforeach
    </section>

</x-app-layout>
