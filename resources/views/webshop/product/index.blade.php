@extends('layouts.website')

@section('content')
    <div class="container">
        <h1 class="mt-4">{{ t($product, 'title') }}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                @foreach($breadcrumbs as $item)
                    <li class="breadcrumb-item"><a href="{{ route('category', $item->slug) }}">{{ t($item, 'title') }}</a></li>
                @endforeach
                <li class="breadcrumb-item"><a href="{{ route('category', $category->slug) }}">{{ t($category, 'title') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ t($product, 'title') }}</li>
            </ol>
        </nav>

        <hr>

        <div class="row product">
            <div class="col-md-6">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($product->assets()->get() as $key => $asset)
                            <li data-target="#carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($product->assets()->get() as $key => $asset)
                            <div class="carousel-item main-image {{ $key == 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$asset->file) }}')"></div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                @if ($product->assets()->count() > 1)
                    <div class="thumbs row mt-4 pb-4">
                        @foreach($product->assets()->limit(3)->get() as $key => $asset)
                            <div class="col">
                                <a class="thumb d-block" href="javascript:;" data-target="#carousel" data-slide-to="{{ $key }}" style="background-image: url('{{ asset('storage/'.$asset->file) }}')"></a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <form method="post" action="{{ route('cart.store', $product) }}">
                    @csrf
                    <div class="description">{!! nl2br(t($product, 'description')) !!}</div>
                    @if ($product->sku)
                        <div class="description mt-2 font-weight-bold">Artikelnummer: {{ $product->sku }}</div>
                    @endif
                    <div class="price mt-2 mb-2">&euro; {{ price($product->price) }}</div>
                    <div class="form-group">
                        <label>Aantal</label>
                        <input type="text" name="qty" value="1" class="form-control col-md-3">
                    </div>
                    <button type="submit" class="btn btn-green">Plaats in winkelwagen</button>
                </form>
            </div>
        </div>
    </div>
@endsection
