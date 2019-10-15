@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Inloggen</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Inloggen bestaande klanten</h2>
                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>E-mailadres</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Wachtwoord</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-green">Inloggen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Aanmelden nieuwe klant</h2>
                        <p>Ik ben nog niet in het bezit van inloggegevens. Deze zou ik graag aan willen maken.</p>
                        <p><a href="#" class="btn btn-green">Aanmelden</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
