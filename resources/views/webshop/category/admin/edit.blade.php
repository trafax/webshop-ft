@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Categorie toevoegen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('category.update', $category) }}">
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
                                <div class="form-group">
                                    <label>Categorienaam</label>
                                    <input type="text" name="title" value="{{ $category->title }}" class="form-control" required>
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
                                    <label>Link <small>optioneel</small></label>
                                    <input type="text" name="slug" class="form-control">
                                </div>
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
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
