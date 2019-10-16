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

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Wijzig mijn gegevens</h2>
                        <form method="post" action="{{ route('customer.update') }}">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Naam</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Adres</label>
                                <input type="text" name="address" value="{{ $user->customer->address }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Postcode</label>
                                <input type="text" name="zipcode" value="{{ $user->customer->zipcode }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Plaats</label>
                                <input type="text" name="city" value="{{ $user->customer->city }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Land</label>
                                <input type="text" name="country" value="{{ $user->customer->country }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Telefoonnummer</label>
                                <input type="text" name="telephone" value="{{ $user->customer->telephone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">E-mailadres</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                            </div>
                            {{-- <div class="form-group">
                                <label>Wachtwoord</label>
                                <input type="password" name="password" class="form-control">
                            </div> --}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-green">Wijzig mijn gegevens</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
