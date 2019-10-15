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

        <form method="post" action="">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h4">Klantgegevens</h2>
                    <hr>
                    <div class="form-group">
                        <label>Naam</label>
                        <input type="text" name="name" value="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Adres</label>
                        <input type="text" name="address" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Postcode</label>
                        <input type="text" name="zipcode" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Plaats</label>
                        <input type="text" name="city" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Land</label>
                        <input type="text" name="country" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Telefoonnummer</label>
                        <input type="text" name="telephone" value="" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <h2 class="h4">Betaalgegevens</h2>
                    <hr>
                </div>
                <div class="col-md-4">
                    <h2 class="h4">Winkelwagen</h2>
                    <hr>
                </div>
            </div>
        </form>

    </div>
@endsection
