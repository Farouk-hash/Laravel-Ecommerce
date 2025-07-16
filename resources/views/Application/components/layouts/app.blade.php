@props([
    'show_nav_bar'      => NULL,
    'show_feature_list' => NULL,
    'show_bread_crump'  => NULL,
    'breadcumptitle'    => null,
    'breadcumpdescription' => __('index.breadcumpdescription'),
    'title'=>$title , 
    'cart_count' => false,
])

<x-header>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="cart_count">{{ $cart_count }}</x-slot>
    {{-- Only render these if their prop is truthy --}}
    @if($show_nav_bar)
        <x-navbar />
    @endif

    @if($show_feature_list)
        <x-feature-list />
    @endif

    @if($show_bread_crump)
        <x-breadcrumb>
            <x-slot name="breadcumptitle">{{ $breadcumptitle }}</x-slot>
            <x-slot name="breadcumpdescription">{{ $breadcumpdescription }}</x-slot>

        </x-breadcrumb>
    @endif

    {{-- Main page content here --}}
    {{ $slot }}
</x-header>

<x-footer />
