@extends('layouts.website')

@section('content')
    <div class="container">

        <h1 class="mt-4">{!! it('search-title', 'Zoeken') !!}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('search-title', 'Zoeken') !!}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">

            <div class="col-md-12">

                {{-- PRODUCTS --}}

                <div class="d-flex my-4">
                    U heeft gezocht op: {{ $request->get('search') }}
                </div>

                @include('webshop.category.partials.products', ['cols_per_row' => 4])

            </div>
        </div>
    </div>

@endsection
