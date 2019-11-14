@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrums_success_payment', 'Betaling gelukt') !!}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h1>{!! it('payment-success-title', 'Betaling gelukt!') !!}</h1>
                {!! it('payment-success-description', '<p>Bedankt voor uw betaling.</p>', true) !!}
            </div>
        </div>

    </div>
@endsection
