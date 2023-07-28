<div class="flex justify-evenly align-baseline border-b border-b-gray-200">

    <a href="{{ route('frontpage') }}"
       class="@if(request()->routeIs('frontpage')) menu-selected @else menu @endif">All News</a>
    <a href="{{ route('grouped') }}"
       class="@if(request()->routeIs('grouped')) menu-selected @else menu @endif">Grouped</a>
    {{-- TODO: add a dropdown menu for the list of providers --}}
    {{-- https://larainfo.com/blogs/create-dropdowns-alpine-js-with-tailwind-css --}}
    {{-- https://alpinejs.dev/component/dropdown --}}
    <a href="{{ route('provider') }}"
       class="@if(request()->routeIs('provider')) menu-selected @else menu @endif">Provider</a>
    <a href="{{ route('archive') }}"
       class="@if(request()->routeIs('archive')) menu-selected @else menu @endif">Archive</a>

</div>
