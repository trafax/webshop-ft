@extends('layouts.website')

@section('content')
    <div class="container">

        <h1 class="mt-4">Webshop</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Webshop</li>
            </ol>
        </nav>

        <hr>

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

        <hr>

        @include('webshop.partials.webshop_index')

    </div>

    @include('partials.create_bar', ['parent_id' => 'webshop'])

    {{-- {!! it('webshop-index-page-description', 'Plaats hier de tekst', true) !!} --}}

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
