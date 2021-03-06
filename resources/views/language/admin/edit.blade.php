@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.language.index') }}">Talen</a></li>
                    <li class="breadcrumb-item active">Taal bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Taal bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.language.update', $language) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <div class="input-group">
                                        <input type="text" name="title" class="form-control" value="{{ $language->title }}" required placeholder="bv. Nederlands">
                                        @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $language->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Taal</label>
                                    <input type="text" name="language" class="form-control" value="{{ $language->language }}" required placeholder="bv. dutch">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Key</label>
                                    <input type="text" name="language_key" class="form-control" value="{{ $language->language_key }}" required placeholder="bv. dutch">
                                </div>
                                <div class="form-group">
                                    <label>Standaard taal</label>
                                    <select class="form-control" name="is_default">
                                        <option value="0">Nee</option>
                                        <option value="1" {{ $language->is_default == 1 ? 'selected' : '' }}>Ja</option>
                                    </select>
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
