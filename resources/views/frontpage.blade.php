<x-app-layout>

    <section class="mt-3">

        <div class="flex justify-end mx-1">
            <span class="text-xs lg:text-sm font-semibold text-gray-700">
                {{ count($articles) }} articles
            </span>
        </div>

    </section>

    <section>

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
                        <a href="{{ route('track', [$article['id'], $allNewsMenu]) }}" target="_blank">
                            {!! html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') !!}
                        </a>
                    </div>

                    <div class="text-xs lg:text-sm text-gray-500 mt-1">
                        {!! $article['content'] !!}
                    </div>

                @if(!empty($article['tags']))
                    <div class="mt-1">
                        <span class="text-xs lg:text-sm text-gray-700"><small>{{ $article['tags'] }}</small></span>
                    </div>
                @endif

                    <div class="flex justify-between mt-2">
                        <div>
                            <span class="text-xs lg:text-sm text-gray-800">
                                <small>Published: {{ $article['published_at'] }}</small>
                            </span>
                        </div>

                        <form action="{{ route('article.delete', $article['id']) }}" method="post">
                            @method('DELETE')
                            @csrf

                            <input type="hidden" name="page" value="{{ $allNewsMenu }}">
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

    </section>

    <section class="my-4">
        <div class="flex justify-center">

            <form action="{{ route('refresh') }}" method="post">
                @csrf

                <input type="hidden" name="page" value="{{ $allNewsMenu }}">

                <button type="submit"
                    class="
                        text-blue-700
                        hover:text-white
                        border
                        border-blue-700
                        hover:bg-blue-800
                        focus:ring-4
                        focus:outline-none
                        focus:ring-blue-300
                        font-medium
                        rounded-lg
                        text-sm
                        lg:text-base
                        px-4
                        lg:px-6
                        py-1.5
                        lg:py-3.5
                        inline-flex
                        text-center">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-3 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Refresh
                </button>
            </form>
        </div>
    </section>

</x-app-layout>
