<x-app-layout>
    <section class="mt-3">

        <div class="flex justify-end mx-1">
            <span class="text-xs lg:text-sm font-semibold text-gray-700">
                {{ count($articles) }} articles
            </span>
        </div>

        <ul class="px-1 mt-1">
        @foreach($articles as $article)
            <li class="flex justify-items-start pb-1 px-1 lg:px-2 gap-2 lg:gap-3 even:bg-gray-100 odd:bg-white rounded-sm">

                <div class="mt-2">
                    <img src="{{ $article['thumbnail'] }}" class="object-contain md:object-scale-down w-20 md:w-24 lg:w-28 rounded-sm"  alt="{{ $article['provider'] }}"/>
                </div>

                <div class="container">
                    <div>
                    @if(empty($article['provider_link']))
                        <span class="text-xs lg:text-sm mr-0 lg:mr-2 text-gray-500 font-semibold"><small>{{ $article['provider'] }}</small></span>
                    @else
                        <a href="{{ $article['provider_link'] }}" class="text-xs lg:text-sm mr-0 lg:mr-2"><small>{{ $article['provider'] }}</small></a>
                    @endif
                        <span class="text-xs lg:text-sm mr-0 lg:mr-1"><small>-</small></span>
                        <span class="text-xs lg:text-sm text-gray-500 font-semibold"><small>{{ $article['feed'] }}</small></span>
                    </div>
                    <div class="text-sm lg:text-base font-medium lg:font-semibold mt-1">
                        <a href="{{ $article['link'] }}" target="_blank">{!! html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') !!}</a>
                    </div>
                    <div class="text-xs lg:text-sm text-gray-500 mt-1">
                        {!! $article['content'] !!}
                    </div>
                @if(!empty($article['tags']))
                    <div class="mt-1">
                        <span class="text-xs lg:text-sm text-gray-700"><small>{{ $article['tags'] }}</small></span>
                    </div>
                @endif
                    <div class="mt-2">
                        <span class="text-xs lg:text-sm text-gray-800"><small>Published: {{ $article['published_at'] }}</small></span>
                    </div>
                </div>

            </li>
        @endforeach
        </ul>

    </section>
</x-app-layout>
