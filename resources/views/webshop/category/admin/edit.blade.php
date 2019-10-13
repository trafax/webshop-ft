@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">Categorieën</a></li>
                    <li class="breadcrumb-item active">Categorie bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Categorie bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.category.update', $category) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#images" role="tab" aria-controls="nav-home" aria-selected="true">Afbeeldingen</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Zoekmachine</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Categorienaam</label>
                                            <div class="input-group">
                                                <input type="text" name="title" class="form-control" value="{{ $category->title }}" required placeholder="bv. Nederlands">
                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $category->id])
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Plaats in</label>
                                            <select class="form-control" name="parent_id">
                                                <option value="">Hoofdcategorie</option>
                                                @php
                                                    $tree = function ($categories, $prefix = '') use (&$tree, $category)
                                                    {
                                                        foreach ($categories as $obj)
                                                        {
                                                            echo '<option value="'.$obj->id.'" '. ($category->parent_id == $obj->id ? 'selected' : '') .'>'. $prefix.' '.$obj->title . '</option>';

                                                            $tree($obj->children, $prefix.'-', $category);
                                                        }
                                                    };

                                                    echo $tree($categories);
                                                @endphp
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Tekst</label>
                                            <textarea name="description" class="form-control" rows="6">{{ $category->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Link <small>optioneel</small></label>
                                            <input type="text" name="slug" value="{{ $category->slug }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="nav-profile-tab">

                                @include('partials.filemanager.admin.input', [
                                    'type' => 'image',
                                    'name' => 'image',
                                    'value' => $category->image
                                ])

                            </div>
                            <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <input type="text" name="seo[title]" class="form-control" value="{{ $category->seo['title'] }}">
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <textarea name="seo[keywords]" class="form-control">{{ $category->seo['keywords'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <textarea name="seo[description]" class="form-control">{{ $category->seo['description'] }}</textarea>
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
