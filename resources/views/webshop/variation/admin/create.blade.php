@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.variation.index') }}">Variaties</a></li>
                    <li class="breadcrumb-item active">Variatie toevoegen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Variatie toevoegen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.variation.store') }}">
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label>Variatienaam</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Kiesbaar</label>
                                    <div class="d-block">
                                        <label><input type="radio" name="selectable" value="0" checked> Nee</label>
                                        <label class="ml-1"><input type="radio" name="selectable" value="1"> Ja</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Zichtbaar in categorie pagina</label>
                                    <div class="d-block">
                                        <label><input type="radio" name="hide" value="0" checked> Ja</label>
                                        <label class="ml-1"><input type="radio" name="hide"> Nee</label>
                                    </div>
                                </div>
                            </div>
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
