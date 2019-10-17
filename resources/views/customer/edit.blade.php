@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mijn gegevens</li>
            </ol>
        </nav>

        <hr>


        <form method="post" action="{{ route('customer.update') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Naam *</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Adres *</label>
                                <input type="text" name="address" value="{{ $user->customer->address }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Postcode *</label>
                                <input type="text" name="zipcode" value="{{ $user->customer->zipcode }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Plaats *</label>
                                <input type="text" name="city" value="{{ $user->customer->city }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Land *</label>
                                <input type="text" name="country" value="{{ $user->customer->country }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Telefoonnummer</label>
                                <input type="text" name="telephone" value="{{ $user->customer->telephone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">E-mailadres *</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                            </div>
                            {{-- <div class="form-group">
                                <label>Wachtwoord</label>
                                <input type="password" name="password" class="form-control">
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> {{ session('message') }}</div>
                    @endif

                    <h2>Wijzig mijn gegevens</h2>
                    <hr>
                    <p>Heb je een nieuw e-mailadres of een ander adres en wil je deze gegevens wijzigen? Het is belangrijk dat we je meest actuele contactgegevens hebben, zodat we je kunnen bereiken als dat nodig is. Geef je nieuwe contactgegevens daarom snel aan ons door.</p>
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-green mr-3">Sla mijn gegevens op</button>

                        @if (Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                            <a href="{{ route('checkout') }}" class="btn btn-light">Ga verder met bestellen</a>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
