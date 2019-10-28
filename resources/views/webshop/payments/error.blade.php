@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Afrekenen</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h1>Betaling mislukt!</h1>
                <p>De betaling is niet gelukt. Probeert u het nogmaals.</p>
                <p><a href="{{ route('checkout') }}" class="btn btn-green">Probeer nogmaals</a></p>
            </div>
        </div>

    </div>
@endsection
