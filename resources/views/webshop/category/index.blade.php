@extends('layouts.website')

@section('content')
    <div class="container">

        <h1 class="mt-4">{{ $category->title }}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                @foreach($breadcrumbs as $item)
                    <li class="breadcrumb-item"><a href="{{ route('category', $item->slug) }}">{{ $item->title }}</a></li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">

            <div class="col-md-3">

                {{-- FILTERS --}}

                <div class="filters">
                    <form method="post" action="{{ route('category.set_variation_filter', $category->slug) }}">
                        @csrf
                        @foreach ($variations as $variation)
                            <div class="card mb-4">
                                <div class="card-header font-weight-bold py-1">{{ $variation->title }}</div>
                                <div class="card-body pb-2 px-3 pt-2 mb-0">
                                    @foreach ($variation->values as $value)
                                        <div class="form-check">
                                            @php $checked = isset($active_variations[$variation->slug]) && in_array($value->slug, explode(',', $active_variations[$variation->slug])) ? 'checked' : '' @endphp
                                            <input type="checkbox" {{ $checked }} name="variations[{{ $variation->slug }}][]" class="form-check-input" value="{{ $value->slug }}" id="{{ $value->title }}">
                                            <label class="form-check-label" for="{{ $value->title }}">{{ $value->title }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                            <li class="list-group-item"><a href="{{ route('category', $item->slug) }}">{{ $item->title }}</a></li>
                        @endforeach
                    </ul>
                    <hr class="mb-4">
                @endif

                {{-- PRODUCTS --}}

                <div class="d-flex border-bottom mb-4">
                    <div class="pt-1 mb-4">Pagina {{ $products->currentPage() }} van {{ $products->lastPage() }}</div>
                    <div class="ml-auto">{{ $products->links() }}</div>
                </div>

                @if ($products->isNotEmpty())
                    <div class="card-deck">
                        @foreach ($products as $key => $product)
                        <div class="card product mb-4">
                            {{-- <img src="..." class="card-img-top" alt="..."> --}}
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">{!! $product->description !!}</p>
                                <a href="#" class="stretched-link"></a>
                            </div>
                        </div>
                        {!! ($key+1) == 4 ? '</div><div class="card-deck">' : '' !!}
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
