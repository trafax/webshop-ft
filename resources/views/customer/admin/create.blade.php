@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Klanten</a></li>
                    <li class="breadcrumb-item active">Klant toevoegen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Klant toevoegen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.customer.store') }}">
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Voornaam *</label>
                                            <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control" required>
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
                                            <label class="font-weight-bold">Achternaam *</label>
                                            <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Straatnaam *</label>
                                    <input type="text" name="street" value="{{ old('street') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Huisnummer *</label>
                                    <input type="text" name="number" value="{{ old('number') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Postcode *</label>
                                    <input type="text" name="zipcode" value="{{ old('zipcode') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Plaats *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Land *</label>
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
                                    <label class="font-weight-bold">E-mailadres *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Wachtwoord *</label>
                                    <input type="password" name="password" value="" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
