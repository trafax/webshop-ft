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
                @foreach ($variations as $variation => $values)
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold">{{ $variation }}</div>
                        <div class="card-body pb-2">
                            @foreach ($values as $value)
                                <label class="d-block"><input type="checkbox" name=""> {{ $value->pivot->title }}</label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
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

                @if ($products->isNotEmpty())
                    <div class="card-deck">
                        @foreach ($products as $key => $product)
                        <div class="card product mb-4">
                            <img src="..." class="card-img-top" alt="...">
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
