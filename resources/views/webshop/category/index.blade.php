@extends('layouts.website')

@section('content')
    <div class="container">

        <h1 class="mt-4">{{ t($category, 'title') }}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                @foreach($breadcrumbs as $item)
                    <li class="breadcrumb-item"><a href="{{ route('category', $item->slug) }}">{{ t($item, 'title') }}</a></li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{ t($category, 'title') }}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">

            <div class="col-md-3">

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

                {{-- FILTERS --}}

                <div class="filters">
                    <form method="post" action="{{ route('category.set_variation_filter', $category->slug) }}">
                        @csrf
                        @foreach ($variations as $variation)
                            @if ($variation->hide == 0)
                                <div class="card mb-4">
                                    <div class="card-header font-weight-bold py-1">{{ t($variation, 'title') }}</div>
                                    <div class="card-body pb-2 px-3 pt-2 mb-0">
                                        @foreach ($variation->values as $value)
                                            <div class="form-check">
                                                @php $checked = isset($active_variations[$variation->slug]) && in_array($value->slug, explode(',', $active_variations[$variation->slug])) ? 'checked' : '' @endphp
                                                <input type="checkbox" {{ $checked }} name="variations[{{ $variation->slug }}][]" class="form-check-input" value="{{ $value->slug }}" id="{{ $value->title }}">
                                                <label class="form-check-label" for="{{ $value->title }}">{{ t($value->slug, 'title', '', $value->title) }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </form>
                </div>

                <script>
                $(function(){
                    $('.filters input[type="checkbox"]').change(function(){
                        $('.filters form').submit();
                    });
                });
                </script>

            </div>

            <div class="col-md-9">

                {{-- SUBCATEGORIES --}}

                @if ($category->children->isNotEmpty() == true)
                    <ul class="list-group list-group-horizontal">
                        @foreach ($category->children as $item)
                            <li class="list-group-item"><a href="{{ route('category', $item->slug) }}">{!! t($item, 'title') !!}</a></li>
                        @endforeach
                    </ul>
                    <hr class="mb-4">
                @endif

                {{-- PRODUCTS --}}

                <div class="d-flex border-bottom mb-4">
                    <div class="pt-1 mb-4">{!! it('pagination-page', 'Pagina') !!} {{ $products->currentPage() }} {!! it('pagination-page-from', 'van') !!} {{ $products->lastPage() }} - ({{ $products->count() }} {!! it('pagination-page-products', 'producten') !!})</div>
                    <div class="ml-auto">{{ $products->links() }}</div>
                </div>

                @include('webshop.category.partials.products')

                <div class="d-flex border-top pt-4 mt-2">
                    <div class="pt-1 mb-4">{!! it('pagination-page', 'Pagina') !!} {{ $products->currentPage() }} {!! it('pagination-page-from', 'van') !!} {{ $products->lastPage() }} - ({{ $products->count() }} {!! it('pagination-page-products', 'producten') !!})</div>
                    <div class="ml-auto">{{ $products->links() }}</div>
                </div>

            </div>
        </div>
    </div>

@endsection
