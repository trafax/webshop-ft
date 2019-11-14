@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrums_error_payment', 'Betaling niet gelukt') !!}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h1>{!! it('payment-error-title', 'Betaling mislukt!') !!}</h1>
                {!! it('payment-error-description', '<p>De betaling is niet gelukt. Probeert u het nogmaals.</p>', true) !!}
                <p><a href="{{ route('checkout') }}" class="btn btn-green">{!! it('payment-error-retry', 'Probeer nogmaals') !!}</a></p>
            </div>
        </div>

    </div>
@endsection
