@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Instellingen</div>
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('setting.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="websitename">Websitenaam</label>
                                <input type="text" name="websitename" id="websitename" class="form-control" value="{{ setting('websitename') }}">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Opslaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
