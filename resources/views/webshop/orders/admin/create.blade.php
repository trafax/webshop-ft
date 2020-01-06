@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Bestellingen</a></li>
                    <li class="breadcrumb-item active">Bestelling plaatsen</li>
                </ol>
            </nav>

            <div class="card mb-4">
                <div class="card-header">
                    Bestelling plaatsen
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.order.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bestaande klant</label>
                                    <select class="form-control" name="id_user">
                                        <option value="">Selecteer een klant</option>
                                        @foreach (\App\Models\User::where('role', 'customer')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->preposition }} {{ $user->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <label class="">Of nieuwe klant</label>

                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Voornaam</label>
                                    <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tussenvoegsel</label>
                                    <input type="text" name="preposition" value="{{ old('preposition') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="font-weight-bold">Achternaam</label>
                                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Straatnaam</label>
                            <input type="text" name="street" value="{{ old('street') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Huisnummer</label>
                            <input type="text" name="number" value="{{ old('number') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Postcode</label>
                            <input type="text" name="zipcode" value="{{ old('zipcode') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Plaats</label>
                            <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Land</label>
                            <select name="language_key" class="form-control">
                                @foreach (App\Models\Country::get() as $country)
                                    <option value="{{ $country->language_key }}">{{ t($country, 'title') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Telefoonnummer</label>
                            <input type="tel" name="telephone" value="{{ old('telephone') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">E-mailadres</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
