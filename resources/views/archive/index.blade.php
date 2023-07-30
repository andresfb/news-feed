<x-app-layout>

    <section class="mt-3">

        <div class="flex justify-between mx-1">
            <span class="text-lg lg:text-xl font-bold text-gray-700">
                All Articles
            </span>

            <span class="text-xs lg:text-sm mt-1 lg:mt-0 font-semibold text-gray-700">
                {{ number_format($articleCount) }} articles
            </span>
        </div>

    </section>

    <section class="mt-2">

        <ul class="px-1 mt-1">
        @foreach($articles as $article)
            <li class="flex justify-items-start pb-1 px-1 lg:px-2 gap-2 lg:gap-3 even:bg-gray-100 odd:bg-white rounded-sm">
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
                        <a href="{{ route('track', [$article['id'], $archiveMenu]) }}" target="_blank">
                            {!! html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') !!}
                        </a>
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

                    <div class="flex justify-start gap-3 lg:gap-5 mt-3">
                        <span class="text-xs lg:text-sm text-gray-800">
                            <small>Published: {{ $article['published_at'] }}</small>
                        </span>

                    @if(!empty($article['read_at']))
                        <span class="text-xs lg:text-sm text-gray-800">
                            <small> - Read: {{ $article['read_at'] }}</small>
                        </span>
                    @endif
                    </div>

                </div>
            </li>
        @endforeach
        </ul>

    </section>

    <section class="mt-7 mb-5">
        {{ $model->withQueryString()->links() }}
    </section>

</x-app-layout>
