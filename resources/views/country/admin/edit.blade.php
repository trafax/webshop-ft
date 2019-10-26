@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.country.index') }}">Landen</a></li>
                    <li class="breadcrumb-item active">Land bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Land bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.country.update', $country) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Titel</label>
                            <div class="input-group">
                                <input type="text" name="title" class="form-control" value="{{ $country->title }}" required>
                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $country->id])
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Korte naam</label>
                            <input type="text" name="language_key" class="form-control" value="{{ $country->language_key }}" required>
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
