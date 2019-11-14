@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order.index') }}">{!! it('breadcrumbs_orders', 'Mijn bestellingen') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrumbs_show_order', 'Bestelling') !!} {{ $order->nr }}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="d-flex">
                    <div>
                        <h2>{!! it('order_title', 'Bestelling') !!} {{ $order->nr }}</h2>
                        {!! it('order_description', '<p>Onderstaand de gegevens van de bestelling.</p>') !!}
                    </div>
                    @if ($order->status == 'paid')
                        <div class="ml-auto"><a href="{{ route('order.download_invoice', $order->id) }}" class="btn btn-green">{!! it('download_invoice', 'Download factuur') !!}</a></div>
                    @endif

                </div>

                <hr class="mt-0">

                <div class="row">
                    <div class="col-md-3">
                        @include('webshop.partials.fast_menu')
                    </div>
                    <div class="col-md-9">
                        <div class="border p-3">
                            @include('webshop.emails.partials.order_details')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
