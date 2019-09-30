@extends('layouts.website')

@section('content')
    <div class="container">

        <h1 class="mt-4">Webshop</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Webshop</li>
            </ol>
        </nav>

        <div class="card-deck">
            @foreach ($categories as $key => $category)
                <div class="card category mb-4">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->title }}</h5>
                        <p class="card-text">{!! $category->description !!}</p>
                        <a href="{{ route('category', $category->slug) }}" class="stretched-link"></a>
                    </div>
                </div>
                {!! ($key+1) == 4 ? '</div><div class="card-deck">' : '' !!}
            @endforeach
        </div>
    </div>
@endsection
