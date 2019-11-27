@extends('layouts.website')

@section('content')

    @include('partials.create_bar', ['parent_id' => $page->id])

    <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'sortable' : '' }} page-blocks" data-action="{{ route('admin.block.sort') }}">
        @foreach ($page->blocks as $block)
            <div class="block position-relative" id="{{ $block->id }}">

                @php
                    $method = ucfirst($block->type) . "Controller";
                    echo \App::make('App\Http\Controllers\\'.$method)->block($block);
                @endphp

            </div>
        @endforeach
    </div>

@endsection
