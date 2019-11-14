@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 pt-4">
            <h2>Aanmelden nieuwe klant</h2>
            <p>Door onderstaande gegevens in te voeren kunt u een account aanmaken.</p>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>E-mailadres</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Wachtwoord</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Bevestig wachtwoord</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Aanmelden') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
