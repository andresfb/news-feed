<x-app-layout>

    <section class="my-7">

        <form action="{{ route('archive') }}" method="get">
            <div class="flex-row md:flex space-y-3 md:space-y-0 md:justify-between md:gap-3 lg:gap-4">

                <div x-data="dropdown()"
                     x-init="loadFeeds({{ $selectedProvider }})"
                     class="w-full">
                    <label for="provider" class="block mb-2 text-sm font-medium text-gray-900">Select a Provider</label>
                    <select @change="loadFeeds($event.target.value)"
                        id="provider"
                        name="provider"
                        class="bg-gray-50
                            border
                            border-gray-300
                            text-gray-900
                            text-sm
                            rounded-lg
                            focus:ring-blue-500
                            focus:border-blue-500
                            block
                            w-full
                            p-2.5">
                        <option @if(empty(old('provider', $selectedProvider))) selected @endif value=""></option>
                    @foreach($providers as $id => $provider)
                        <option value="{{ $id }}" @if($id === old('provider', $selectedProvider)) selected @endif >{{ $provider }}</option>
                    @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="feed" class="block mb-2 text-sm font-medium text-gray-900">Select a Feed</label>
                    <select x-bind:disabled="!feedsLoaded"
                        id="feed"
                        name="feed"
                        class="bg-gray-50
                            border
                            border-gray-300
                            text-gray-900
                            text-sm
                            rounded-lg
                            focus:ring-blue-500
                            focus:border-blue-500
                            block
                            w-full
                            p-2.5">
                        <template x-for="feed in feeds">
                            <option x-bind:value="feed.id" x-text="feed.title" x-bind:selected="feed.id === {{ $selectedFeed }}"></option>
                        </template>
                    </select>
                </div>

                <div class="w-full">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Read Status</label>
                    <select id="status"
                        name="status"
                        class="bg-gray-50
                            border
                            border-gray-300
                            text-gray-900
                            text-sm
                            rounded-lg
                            focus:ring-blue-500
                            focus:border-blue-500
                            block
                            w-full
                            p-2.5">
                        @foreach($statuses as $id => $status)
                            <option value="{{ $id }}" @if($id === old('status', $selectedStatus)) selected @endif >{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="from_date" class="block mb-2 text-sm font-medium text-gray-900">From Date</label>
                    <input id="from_date"
                        type="date"
                        name="from_date"
                        value="{{ old('from_date', $fromDate) }}"
                        class="bg-gray-50
                            border
                            border-gray-300
                            text-gray-900
                            text-sm
                            rounded-lg
                            focus:ring-blue-500
                            focus:border-blue-500
                            block
                            w-full
                            p-2.5">
                </div>

                <div class="w-full">
                    <label for="to_date" class="block mb-2 text-sm font-medium text-gray-900">To Date</label>
                    <input id="to_date"
                        type="date"
                        name="to_date"
                        value="{{ old('to_date', $toDate) }}"
                        class="bg-gray-50
                            border
                            border-gray-300
                            text-gray-900
                            text-sm
                            rounded-lg
                            focus:ring-blue-500
                            focus:border-blue-500
                            block
                            w-full
                            p-2.5">
                </div>

                <div class="flex justify-between gap-3 pt-2 md:pt-7">
                    <button type="submit"
                        class="text-blue-700
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
                            lg:px-5
                            py-1.5
                            inline-flex
                            text-center">Filter</button>

                    <button x-data="{ refresh: '{{ route('archive') }}' }"
                        type="button"
                        @click="window.location.href=refresh"
                        class="text-gray-700
                            hover:text-white
                            border
                            border-gray-700
                            hover:bg-gray-800
                            focus:ring-4
                            focus:outline-none
                            focus:ring-gray-300
                            font-medium
                            rounded-lg
                            text-sm
                            lg:text-base
                            px-4
                            lg:px-5
                            py-1.5
                            inline-flex
                            text-center">Reset</button>
                </div>

            </div>
        </form>

    </section>

    <hr>
    <section class="mt-4">

        <div class="flex justify-between mx-1">
            <span class="text-lg lg:text-xl font-bold text-gray-700">
                {{ $title }}
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

    <script>
        function dropdown() {
            return {
                feeds: [],
                feedsLoaded: false,
                async loadFeeds(providerId) {
                    if (providerId === '' || providerId === 0) {
                        this.states = [];
                        this.statesLoaded = false;
                        return;
                    }

                    const response = await fetch(`/ajax/feeds?provider=${providerId}`);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    this.feeds = await response.json();
                    this.feedsLoaded = true;
                }
            };
        }
    </script>
</x-app-layout>
