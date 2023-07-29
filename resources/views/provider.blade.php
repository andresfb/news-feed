<x-app-layout>

    <section class="mt-3">
    @if(empty($provider_id))
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
                            <div class="mt-1">
                                <span
                                    class="text-xs lg:text-sm text-gray-800"><small>Published: {{ $article['published_at'] }}</small></span>
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
