@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.variation.index') }}">Variaties</a></li>
                    <li class="breadcrumb-item active">Variatie bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Variatie bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.variation.update', $variation) }}">
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
                                    <div class="input-group">
                                        <input type="text" name="title" value="{{ $variation->title }}" class="form-control" required>
                                        @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $variation->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Kiesbaar</label>
                                    <div class="d-block">
                                        <label><input type="radio" name="selectable" value="0" {{ $variation->selectable == 0 ? 'checked' : '' }}> Nee</label>
                                        <label class="ml-1"><input type="radio" name="selectable" value="1" {{ $variation->selectable == 1 ? 'checked' : '' }}> Ja</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Zichtbaar in categorie pagina</label>
                                    <div class="d-block">
                                        <label><input type="radio" name="hide" value="0" {{ $variation->hide == 0 ? 'checked' : '' }}> Ja</label>
                                        <label class="ml-1"><input type="radio" name="hide" value="1" {{ $variation->hide == 1 ? 'checked' : '' }}> Nee</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Sorteer op</label>
                                    <select name="sort_by" class="form-control col-2">
                                        <option value="title" {{ $variation->sort_by == 'title' ? 'selected' : '' }}>Titel</option>
                                        <option value="price" {{ $variation->sort_by == 'price' ? 'selected' : '' }}>Prijs</option>
                                        <option value="number_in_string" {{ $variation->sort_by == 'number_in_string' ? 'selected' : '' }}>Getal in tekst</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Toon aantal keer besteld in productenlijst</label>
                                    <select name="show_ordered" class="form-control col-2">
                                        <option value="0">Nee</option>
                                        <option value="1" {{ $variation->show_ordered == 1 ? 'selected' : '' }}>Ja</option>
                                    </select>
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
