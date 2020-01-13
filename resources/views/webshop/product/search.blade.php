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

                <form method="post" action="{{ route('product.search') }}">
                    @csrf
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <input type="text" name="search" placeholder="Zoek een product..." class="form-control py-4">
                            <div class="input-group-append">
                                <span class="input-group-text"><button class="bg-transparent border-0"><i class="fas fa-search"></i></button></span>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- PRODUCTS --}}

                <div class="d-flex my-4">
                    {!! it('you-have-search-on', 'U heeft gezocht op:') !!} {{ $request->get('search') }}
                </div>

                <div class="d-flex border-bottom mb-4">
                    <div class="pt-1 mb-4">{!! it('pagination-page', 'Pagina') !!} {{ $products->currentPage() }} {!! it('pagination-page-from', 'van') !!} {{ $products->lastPage() }} - ({{ $products->count() }} {!! it('pagination-page-products', 'producten') !!})</div>
                    <div class="ml-auto">{{ $products->links() }}</div>
                </div>

                @include('webshop.category.partials.products', ['cols_per_row' => 4])

            </div>
        </div>
    </div>

@endsection
