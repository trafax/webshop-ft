@extends('layouts.website')

@section('content')

    @include('partials.create_bar', ['parent_id' => 'homepage'])

    {{-- <div class="container">
        <h2 class="mt-4">{!! it('homepage-zoeken', 'Zoeken in de website') !!}</h2>
        <form method="post" action="{{ route('product.search') }}">
            @csrf
            <div class="form-group py-4">
                <div class="input-group">
                    <input type="text" name="search" placeholder="Zoek een product..." class="form-control py-4">
                    <div class="input-group-append">
                        <span class="input-group-text"><button class="bg-transparent border-0"><i class="fas fa-search"></i></button></span>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}

    <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'sortable' : '' }}" data-action="{{ route('admin.block.sort') }}">
        @foreach ($blocks as $block)
            <div class="block position-relative" id="{{ $block->id }}">

                @php
                    $method = ucfirst($block->type) . "Controller";
                    echo \App::make('App\Http\Controllers\\'.$method)->block($block);
                @endphp

            </div>
        @endforeach
    </div>

@endsection
