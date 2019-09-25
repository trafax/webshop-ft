@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Product toevoegen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('product.store') }}">
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="nav-profile" aria-selected="false">Categorieën</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Zoekmachine</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label>Productnaam</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Link <small>optioneel</small></label>
                                    <input type="text" name="slug" class="form-control">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Plaats in</label>
                                    <select class="form-control" name="parent_id[]" multiple size="20">
                                        <option value="">Hoofdcategorie</option>
                                        @php
                                            $tree = function ($categories, $prefix = '') use (&$tree)
                                            {
                                                foreach ($categories as $obj)
                                                {
                                                    echo '<option value="'.$obj->id.'">'. $prefix.' '.$obj->title . '</option>';

                                                    $tree($obj->children, $prefix.'-');
                                                }
                                            };

                                            echo $tree($categories);
                                        @endphp
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <input type="text" name="seo[title]" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <textarea name="seo[keywords]" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <textarea name="seo[description]" class="form-control"></textarea>
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
