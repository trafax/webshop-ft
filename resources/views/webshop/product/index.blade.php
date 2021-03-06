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
            <div class="col-md-6 pb-2">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($product->assets()->get() as $key => $asset)
                            <li data-target="#carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($product->assets()->get() as $key => $asset)
                            <div class="carousel-item main-image {{ $key == 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$asset->file) }}')">
                                <a href="{{ asset('storage/'.$asset->file) }}" class="stretched-link" data-fancybox="images"></a>
                            </div>
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

                <script>
                    $(function(){
                        window.toggleDescription = function(){
                            var $object = $('.c_description');
                            if ($object.css('height') == '200px') {
                                $object.removeAttr('style');
                            } else {
                                $object.attr('style', 'height: 200px; overflow: hidden;');
                            }
                        };

                    });
                </script>

                @php
                    if ($category->description)
                        $description = t($category, 'description');
                    else
                        $description = t($product, 'description');
                @endphp

                @if ($description)
                    <div class="description c_description" style=" height: 200px; overflow: hidden;">
                        {!! $description !!}
                    </div>
                    <a href="javascript:;" onclick="window.toggleDescription()" class="btn btn-green mt-3">{!! it('product-read-more', 'Lees meer') !!}</a>
                @endif
            </div>
            <div class="col-md-6 pb-2">
                <form method="post" action="{{ route('cart.store', $product) }}">
                    @csrf
                    @if ($product->sku)
                        <div class="description mb-2 font-weight-bold">{!! it('webshop-product-sku', 'Artikelnummer') !!}: {{ $product->sku }}</div>
                    @endif

                    <div class="specs">
                        @php
                            if ($category->specs)
                                $specs = t($category, 'specs');
                            else
                                $specs = t($product, 'specs');
                        @endphp

                        {!! $specs !!}
                    </div>

                    <div class="mt-2 mb-2 default_price" data-default_price="{{ $product->price }}">
                        <span class="price">&euro; {{ price($product->price) }}</span>
                    </div>

                    @if ($product->sold_out == 0)
                        @foreach ($variations as $key => $variation)
                            @php $rows = $product->variations->where('title', $variation->title)->where('pivot.sold_out', 0); @endphp
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
                                        <option value="{{ $row->pivot->slug }}" {!! $data_attr !!}>{{ t($row->pivot->slug, 'title', '', $row->pivot->title) }} {!! $price !!}</option>
                                    @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach

                        <div class="form-group">
                            <label>{!! it('webshop-product-qty', 'Aantal') !!}</label>
                            <input type="text" name="qty" value="1" class="form-control col-md-3">
                        </div>

                        @php
                            $available_from = @$product->categories()->whereNotIn('id', ['095f3790-3cf1-11ea-ba3d-cd54ccfc87f5', '5ec7af50-6e7e-11ea-9eff-0b0a479b45dc'])->first()->available_from ?? null;
                        @endphp
                        @if ($available_from)
                            <div class="description mb-2">
                                <div class="alert alert-warning" role="alert">
                                    <b>{!! it('webshop-product-available_from', 'Beschikbaar vanaf') !!}:</b> {{ $available_from }}
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-green">{!! it('webshop-product-add-to-cart', 'Plaats in winkelwagen') !!}</button>
                    @else

                        <span class="text-warning">{!! it('product-status-sold-out', 'Helaas, het artikel is uitverkocht.') !!}</span>

                    @endif
                </form>
            </div>
        </div>
        @if ($product->related->count() > 0)
            <br>
            <hr class="mb-2">
            <h2 class="mt-4">{!! it('related-products-title', 'Gerelateerde artikelen') !!}</h2>
            <div class="card-deck products mt-4">
                @foreach ($product->related as $related)
                    @if ($related->product->visible == 1)
                        <div class="card product mb-4">
                            @if ($related->product->sold_out == 1)
                                <div class="sold-out">{!! it('product-sold-out', 'Uitverkocht') !!}</div>
                            @endif
                            @if ($related->product->assets()->get()->first())
                                <div class="image" style="background-image: url('/storage/{{ $related->product->assets()->get()->first()->file }}')"></div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ t($related->product, 'title') }}</h5>
                                <a href="{{ route('product', $related->product->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endif
                    {!! $loop->iteration % 4 == 0 ? '</div><div class="card-deck products">' : '' !!}
                @endforeach
            </div>
        @endif
    </div>
@endsection
