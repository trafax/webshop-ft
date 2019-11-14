@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.page.index') }}">Pagina's</a></li>
                    <li class="breadcrumb-item active">Pagina aanpassen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Pagina aanpassen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.page.update', $page) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Zoekmachine</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Naam</label>
                                            <div class="input-group">
                                                <input type="text" name="title" class="form-control" required value="{{ $page->title }}">
                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $page->id])
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Plaats onder</label>
                                            <select class="form-control" name="parent_id">
                                                <option value="0">Hoofdmenu item</option>
                                                @foreach ($pages as $obj)
                                                    <option value="{{ $obj->id }}" {{ $page->parent_id == $obj->id ? 'selected' : '' }}>{{ $obj->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Link <small>optioneel</small></label>
                                            <input type="text" name="slug" class="form-control" value={{ $page->slug }}>
                                        </div>
                                        <div class="form-group">
                                            <label>Zichtbaar in menu</label>
                                            <select name="show_in_menu" class="form-control">
                                                <option value="1">Ja</option>
                                                <option value="0" {{ $page->show_in_menu == 0 ? 'selected' : '' }}>Nee</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <input type="text" name="seo[title]" class="form-control" value="{{ $page->seo['title'] }}">
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <textarea name="seo[keywords]" class="form-control">{{ $page->seo['keywords'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <textarea name="seo[description]" class="form-control">{{ $page->seo['description'] }}</textarea>
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
