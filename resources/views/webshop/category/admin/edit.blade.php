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
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#specs" role="tab" aria-controls="nav-profile" aria-selected="false">Specificaties</a>
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
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Link <small>optioneel</small></label>
                                            <input type="text" name="slug" value="{{ $category->slug }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Zichtbaar</label>
                                            <select name="visible" class="form-control">
                                                <option value="1">Ja</option>
                                                <option value="0" {{  $category->visible == 0 ? 'selected' : '' }}>Nee</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Seizoen</label>
                                            <select name="season" class="form-control">
                                                <option value="0">Voorjaar</option>
                                                <option value="1" {{  $category->season == 1 ? 'selected' : '' }}>Zomer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Toon categorie in uitgelicht</label>
                                            <select name="featured" class="form-control">
                                                <option value="0">Nee</option>
                                                <option value="1" {{ $category->featured ? 'selected' : '' }}>Ja</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Beschikbaar vanaf</label>
                                            <div class="input-group">
                                                <input type="text" name="available_from" class="form-control" value="{{ $category->available_from }}">
                                                @include('language.admin.partials.translate', ['field' => 'available_from', 'parent_id' => $category->id])
                                            </div>
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
                                    <div class="input-group">
                                        <input type="text" name="seo[title]" class="form-control" value="{{ $category->seo['title'] }}">
                                        @include('language.admin.partials.translate', ['field' => 'seo[title]', 'parent_id' => $category->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <div class="input-group">
                                        <textarea name="seo[keywords]" class="form-control">{{ $category->seo['keywords'] }}</textarea>
                                        @include('language.admin.partials.translate', ['field' => 'seo[keywords]', 'parent_id' => $category->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <div class="input-group">
                                        <textarea name="seo[description]" class="form-control">{{ $category->seo['description'] }}</textarea>
                                        @include('language.admin.partials.translate', ['field' => 'seo[description]', 'parent_id' => $category->id])
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="p-2 bg-warning mb-3">
                                    <label class="m-0"><input type="checkbox" name="place_in_all" value="1" class="checkbox mr-2"> Plaats deze specificaties en tekst in alle producten.</label>
                                </div>
                                <hr>
                                <label>Specificaties</label>
                                <div class="form-group">
                                    <textarea name="specs" class="form-control editor">{{ $category->specs }}</textarea>
                                    @include('language.admin.partials.translate', ['field' => 'specs', 'parent_id' => $category->id, 'editor' => true])
                                </div>
                                <div class="form-group">
                                    <label>Tekst</label>
                                    <textarea name="description" class="form-control editor" rows="6">{{ $category->description }}</textarea>
                                    @include('language.admin.partials.translate', ['field' => 'description', 'parent_id' => $category->id, 'editor' => true])
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
