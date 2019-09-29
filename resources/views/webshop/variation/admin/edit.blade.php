@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('variation.index') }}">Variaties</a></li>
                    <li class="breadcrumb-item active">Variatie bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Variatie bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('variation.update', $variation) }}">
                        @method('PUT')
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                {{-- <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#options" role="tab" aria-controls="nav-home" aria-selected="true">Opties</a> --}}
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label>Variatienaam</label>
                                    <input type="text" name="title" value="{{ $variation->title }}" class="form-control" required>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="nav-home-tab">

                            </div> --}}
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
