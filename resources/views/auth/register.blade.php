@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 pt-4">
            <h2>{!! it('sign-up-customer-title', 'Aanmelden nieuwe klant') !!}</h2>
            {!! it('sign-up-customer-description', '<p>Door onderstaande gegevens in te voeren kunt u een account aanmaken.</p>', true) !!}
            <hr>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>{!! it('sign-up-name', 'Naam') !!}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>{!! it('sign-up-email', 'E-mailadres') !!}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{!! it('sign-up-password', 'Wachtwoord') !!}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{!! it('sign-up-confirm-password', 'Bevestig wachtwoord') !!}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {!! it('sign-up-btn', 'Aanmelden') !!}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
