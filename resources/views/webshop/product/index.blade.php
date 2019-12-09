@extends('layouts.website')

@section('content')
    <div class="container">
        <h1 class="mt-4">{{ t($product, 'title') }}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                @foreach($breadcrumbs as $item)
                    <li class="breadcrumb-item"><a href="{{ route('category', $item->slug) }}">{{ t($item, 'title') }}</a></li>
                @endforeach
                @if ($category->slug)
                    <li class="breadcrumb-item"><a href="{{ route('category', $category->slug) }}">{{ t($category, 'title') }}</a></li>
                @endif
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

                <div class="description">{!! t($product, 'description') !!}</div>
            </div>
            <div class="col-md-6">
                <form method="post" action="{{ route('cart.store', $product) }}">
                    @csrf
                    @if ($product->sku)
                        <div class="description mb-2 font-weight-bold">{!! it('webshop-product-sku', 'Artikelnummer') !!}: {{ $product->sku }}</div>
                    @endif
                    <div class="specs">{!! t($product, 'specs') !!}</div>
                    <div class="mt-2 mb-2 default_price" data-default_price="{{ $product->price }}">
                        <span class="price">&euro; {{ price($product->price) }}</span>
                    </div>

                    @if ($product->sold_out == 0)
                        @foreach ($variations as $key => $variation)
                            @php $rows = $product->variations->where('title', $variation->title); @endphp
                            @if ($rows->count() > 0)
                                <div class="form-group">
                                    <label>{{ t($variation, 'title') }}</label>
                                    <select class="form-control option_select" name="options[{{ $variation->slug }}]">
                                    @foreach ($rows as $row)
                                        @php
                                            $data_attr = '';
                                            $price = '';
                                            if ($row->pivot->fixed_price > 0)
                                            {
                                                $data_attr = 'data-fixed_price="'. $row->pivot->fixed_price .'"';
                                                $price = '(&euro; '.price($row->pivot->fixed_price).')';
                                            }
                                            else if ($row->pivot->adding_price > 0)
                                            {
                                                $data_attr = 'data-adding_price="'. $row->pivot->adding_price .'"';
                                                $price = '+ (&euro; '.$row->pivot->adding_price.')';
                                            }
                                        @endphp
                                        <option value="{{ $row->pivot->slug }}" {!! $data_attr !!}>{{ $row->pivot->title }} {!! $price !!}</option>
                                    @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach

                        <div class="form-group">
                            <label>{!! it('webshop-product-qty', 'Aantal') !!}</label>
                            <input type="text" name="qty" value="1" class="form-control col-md-3">
                        </div>
                        <button type="submit" class="btn btn-green">{!! it('webshop-product-add-to-cart', 'Plaats in winkelwagen') !!}</button>
                    @else

                        <span class="text-warning">{!! it('product-status-sold-out', 'Helaas, het artikel is uitverkocht.') !!}</span>

                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
