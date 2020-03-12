@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrumb_login', 'Inloggen') !!}</li>
            </ol>
        </nav>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>{!! it('login_existing_title', 'Inloggen bestaande klant') !!}</h2>
                        {!! it('login_existing_description', '&nbsp;', true) !!}

                        @foreach ($errors->all() as $error)
                            <div class="alert alert-warning mt-0">{{ $error }}</div>
                        @endforeach

                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>{!! it('login_email', 'E-mailadres') !!}</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>{!! it('login_password', 'Wachtwoord') !!}</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-green">{!! it('login-btn', 'Inloggen') !!}</button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {!! it('login-forgot-password', 'Wachtwoord vergeten?') !!}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>{!! it('login_new_title', 'Aanmelden nieuwe klant') !!}</h2>
                        {!! it('login_new_description', '<p>Ik ben nog niet in het bezit van inloggegevens. Deze zou ik graag aan willen maken.</p>', true) !!}
                        <a href="{{ route('register') }}" class="btn btn-green">{!! it('sign-up-btn', 'Aanmelden') !!}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
