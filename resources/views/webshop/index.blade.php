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

        <div class="card-deck">
            @foreach ($categories as $key => $category)
                <div class="card category mb-4">
                    @if (isset($category->image) && $category->image)
                        <div class="image" style="background-image: url('{{ $category->image }}')"></div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{!! t($category, 'title') !!}</h5>
                        {{-- <p class="card-text">{!! $category->description !!}</p> --}}
                        <a href="{{ route('category', $category->slug) }}" class="stretched-link"></a>
                    </div>
                </div>
                {!! ($key+1) % 4 == 0 ? '</div><div class="card-deck">' : '' !!}
            @endforeach
        </div>
    </div>
@endsection
