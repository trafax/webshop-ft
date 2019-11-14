@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mijn bestellingen</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h2>Mijn bestellingen</h2>
                <p>Onderstaand uw geplaatste bestellingen.</p>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        @include('webshop.partials.fast_menu')
                    </div>
                    <div class="col-md-9">
                        <ul class="list-group">
                            @foreach ($orders as $order)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-1">{{ $order->nr }}</div>
                                        <div class="col">{{ $order->created_at->format('d-m-Y \o\m H:i') }}</div>
                                        <div class="col-md-2">€ {{ price($order->total) }}</div>
                                        <div class="col-md-1">{{ $order->status }}</div>
                                        <div class="col text-right"><a href="{{ route('order.show', $order) }}">Bekijk bestelling</a></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
