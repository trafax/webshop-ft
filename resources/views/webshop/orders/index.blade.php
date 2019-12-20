@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrumbs_my_orders', 'Mijn bestellingen') !!}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h2>{!! it('my_orders', 'Mijn bestellingen') !!}</h2>
                {!! it('my_orders_description', '<p>Onderstaand uw geplaatste bestellingen.</p>', true) !!}
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        @include('webshop.partials.fast_menu')
                    </div>
                    <div class="col-md-9">
                        <ul class="list-group">
                            @forelse ($orders as $order)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">{{ $order->nr }}</div>
                                        <div class="col">{{ $order->created_at->format('d-m-Y \o\m H:i') }}</div>
                                        <div class="col-md-2">€ {{ price($order->total) }}</div>
                                        <div class="col-md-1">{{ $order->status }}</div>
                                        <div class="col text-right"><a href="{{ route('order.show', $order) }}">{!! it('show_order', 'Bekijk bestelling') !!}</a></div>
                                    </div>
                                </li>
                            @empty
                                <p>{!! it('no-orders-found', 'Er zijn nog geen bestelling bekend in ons systeem.') !!}</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
