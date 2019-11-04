@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.country.index') }}">Landen</a></li>
                    <li class="breadcrumb-item active">Land toevoegen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Land toevoegen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.country.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Titel</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Korte naam</label>
                            <input type="text" name="language_key" class="form-control" required>
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
