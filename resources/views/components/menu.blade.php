<div class="flex justify-evenly align-baseline border-b border-b-gray-200">

    <a href="{{ route('frontpage') }}" class="@if(request()->routeIs('frontpage')) menu-selected @else menu @endif">All News</a>

    <a href="{{ route('grouped') }}" class="@if(request()->routeIs('grouped')) menu-selected @else menu @endif">Grouped</a>

    <div class="relative" x-data="{dropdownMenu: false}">
        <!-- Dropdown toggle button -->
        <a href="#" class="flex items-center @if($providerRoutes->contains(request()->route())) menu-selected @else menu @endif" @click="dropdownMenu = !dropdownMenu">
            <span class="mr-0 lg:mr-0.5">Provider</span>
            <!-- Heroicon: chevron-down -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 lg:h-5 w-4 lg:w-5 mt-0.5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <!-- Dropdown list -->
        <div x-show="dropdownMenu" class="absolute right-0 py-2 mt-2 bg-gray-100 rounded-md shadow-xl w-48">
        @foreach($providers as $id => $provider)
            <a href="{{ route('provider', $id) }}" class="block px-4 py-2 menu">
                {{ $provider }}
            </a>
        @endforeach
        </div>
    </div>

    <a href="{{ route('archive') }}" class="@if(request()->routeIs('archive')) menu-selected @else menu @endif">Archive</a>

</div>
