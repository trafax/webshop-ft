@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Producten</a></li>
                    <li class="breadcrumb-item active">Product toevoegen</li>
                </ol>
            </nav>

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
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#variations" role="tab" aria-controls="nav-profile" aria-selected="false">Variaties</a>
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
                            <div class="tab-pane fade" id="variations" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <p>Opties kunnen op onderstaande manier toegoevoegd worden per variatie. Iedere regel is een nieuwe optie.<br>
                                <i><strong>naam, vaste prijs, meerprijs</strong></i></p>
                                <div class="card-group">
                                    @foreach ($variations as $key => $variation)
                                        <div class="card mb-4">
                                            <div class="card-header font-weight-bold">{{ $variation->title }}</div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea name="variations[{{ $variation->id }}]" rows="8" class="form-control" placeholder="naam, vaste prijs, meerprijs"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {!! ($key+1) % 3 == 0 ? '</div><div class="card-group mb-4">' : '' !!}
                                    @endforeach
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
