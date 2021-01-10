@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Producten</a></li>
                    <li class="breadcrumb-item active">Product bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Product bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.product.update', $product) }}">
                        @method('PUT')
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="nav-profile" aria-selected="false">Categorieën</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#images" role="tab" aria-controls="nav-profile" aria-selected="false">Afbeeldingen</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#variations" role="tab" aria-controls="nav-profile" aria-selected="false">Variaties</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#related_products" role="tab" aria-controls="nav-profile" aria-selected="false">Gerelateerde producten</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Zoekmachine</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Productnaam</label>
                                            <div class="input-group">
                                                <input type="text" name="title" value="{{ $product->title }}" class="form-control" required>
                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $product->id])
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tekst</label>
                                            <textarea name="description" class="form-control editor" rows="12">{{ $product->description }}</textarea>
                                            @include('language.admin.partials.translate', ['field' => 'description', 'parent_id' => $product->id, 'editor' => true])
                                        </div>
                                        <div class="form-group">
                                            <label>Specificaties</label>
                                            <textarea name="specs" class="form-control editor" rows="8">{{ $product->specs }}</textarea>
                                            @include('language.admin.partials.translate', ['field' => 'specs', 'parent_id' => $product->id, 'editor' => true])
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Artikelnummer</label>
                                            <input type="text" name="sku" value="{{ $product->sku }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Prijs</label>
                                            <input type="text" name="price" value="{{ $product->price }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Link <small>optioneel</small></label>
                                            <input type="text" name="slug" value="{{ $product->slug }}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Uitverkocht</label>
                                            <select name="sold_out" class="form-control">
                                                <option value="0">Nee</option>
                                                <option value="1" {{ $product->sold_out ? 'selected' : '' }}>Ja</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Toon product in uitgelicht</label>
                                            <select name="featured" class="form-control">
                                                <option value="0">Nee</option>
                                                <option value="1" {{ $product->featured ? 'selected' : '' }}>Ja</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Toon melding bij product</label>
                                            <div class="input-group">
                                                <input type="text" name="status" value="{{ $product->status }}" class="form-control">
                                                @include('language.admin.partials.translate', ['field' => 'status', 'parent_id' => $product->id])
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Zichtbaar in website</label>
                                            <select name="visible" class="form-control">
                                                <option value="1">Ja</option>
                                                <option value="0" {{ $product->visible == 0 ? 'selected' : '' }}>Nee</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <label>Plaats in</label>
                                <small class="d-block">Selecteer er meerdere tegelijk door de knop ctrl ingedrukt te houden.</small>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        Voorjaars categorieen
                                        <select class="form-control" name="parent_id[]" multiple size="20">
                                            @php
                                                $tree = function ($categories, $prefix = '') use (&$tree, $product)
                                                {
                                                    foreach ($categories as $obj)
                                                    {
                                                        $selected = in_array($obj->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '';
                                                        echo '<option value="'.$obj->id.'" '. $selected .'>'. $prefix.' '.$obj->title . '</option>';

                                                        $tree($obj->children, $prefix.'-');
                                                    }
                                                };

                                                echo $tree($spring_categories);
                                            @endphp
                                        </select>
                                    </div>
                                    <div class="col">
                                        Zomer categorieen
                                        <select class="form-control" name="parent_id[]" multiple size="20">
                                            @php
                                                $tree = function ($categories, $prefix = '') use (&$tree, $product)
                                                {
                                                    foreach ($categories as $obj)
                                                    {
                                                        $selected = in_array($obj->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '';
                                                        echo '<option value="'.$obj->id.'" '. $selected .'>'. $prefix.' '.$obj->title . '</option>';

                                                        $tree($obj->children, $prefix.'-');
                                                    }
                                                };

                                                echo $tree($summer_categories);
                                            @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">


                                </div>
                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="row">
                                    <div class="col-md-6 image-wrapper">
                                        <div class="image-container">
                                                <script>
                                                    function delFile(action)
                                                    {
                                                        if (confirm('Afbeelding verwijderen?'))
                                                        {
                                                            $.ajax({
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                },
                                                                url: action,
                                                                type: 'GET',
                                                                success: function(){
                                                                    $('.image-wrapper').load('{{ route('admin.product.edit', $product) }} .image-container', function(){
                                                                        window.sort();
                                                                    });
                                                                }
                                                            });
                                                        }

                                                        return false;
                                                    }
                                                </script>
                                            <div class="row sortable" data-action="{{ route('admin.asset.sort') }}">
                                                @forelse ($product->assets as $asset)
                                                    <div class="col-md-3 mb-3" id="{{ $asset->id }}">
                                                        <div class="thumb" style="background-image: url('/storage/{{ $asset->file }}');">
                                                            <a href="javascript:;" onclick="return delFile('{{ route('admin.asset.delete', $asset) }}')" class="stretched-link">X</a>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <p class="col mb-3">Er zijn nog geen afbeeldingen geupload.</p>
                                                @endempty
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <script type="text/javascript">
                                            Dropzone.options.customDropzone = {
                                                url: '{{ route('admin.asset.upload') }}',
                                                dictDefaultMessage: '- Sleep uw bestanden hierin om deze to uploaden -',
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                init: function() {
                                                    this.on("sending", function(file, xhr, formData){
                                                        formData.append('parent_id', '{{ $product->id }}');
                                                    });
                                                    this.on("complete", function (file) {
                                                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                                            $('.image-wrapper').load('{{ route('admin.product.edit', $product) }} .image-container', function(){
                                                                window.sort();
                                                            });
                                                        }
                                                    });
                                                }
                                            };
                                        </script>
                                        <div class="dropzone" id="customDropzone"></div>
                                    </div>
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
                                                @php $text = ''; @endphp
                                                @foreach ($product->variations->where('title', $variation->title) as $row)

                                                    <div class="row">
                                                        <div class="col-1">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch mt-2" title="Beschikbaar">
                                                                    <input type="checkbox" value="0" class="custom-control-input" {{ $row->pivot->sold_out == 0 ? 'checked' : '' }} id="customSwitch{{ $row->pivot->id }}" name="variations[{{ $row->pivot->id }}][sold_out]">
                                                                    <label class="custom-control-label" for="customSwitch{{ $row->pivot->id }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <input type="text" name="variations[{{ $row->pivot->id }}][title]" value="{{ $row->pivot->title }}" class="form-control" placeholder="Titel">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <input type="text" name="variations[{{ $row->pivot->id }}][fixed_price]" value="{{ $row->pivot->fixed_price ?? '' }}" class="form-control" placeholder="Vaste prijs">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <input type="text" name="variations[{{ $row->pivot->id }}][adding_price]" value="{{ $row->pivot->adding_price ?? '' }}" class="form-control" placeholder="Extra prijs">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">

                                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $row->pivot->id])
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- @php $text .= $row->pivot->title .
                                                    ($row->pivot->fixed_price ? ', '. $row->pivot->fixed_price : '') .
                                                    ($row->pivot->adding_price ? ', '. $row->pivot->adding_price : '') . "\n"
                                                    @endphp --}}
                                                @endforeach
                                                <div class="form-group">
                                                    <textarea name="new_variations[{{ $variation->id }}]" rows="8" class="form-control" placeholder="naam, vaste prijs, meerprijs"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {!! ($key+1) % 2 == 0 ? '</div><div class="card-group mb-4">' : '' !!}
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="related_products" role="tabpanel" aria-labelledby="nav-profile-tab">

                                <script>
                                $(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $('.add-product').on('click', function(){
                                        $.ajax({
                                            data: {id: '{{ $product->id }}', sku: $('[name="search_sku"]').val()},
                                            url: '{{ route("admin.related_product.insert") }}',
                                            type: 'POST',
                                            success: function(response){
                                                $('#related-products').load('{{ route('admin.product.edit', $product) }} #related');
                                            },
                                            error: function() {
                                                alert('Product niet gevonden.');
                                            },
                                            dataType: 'json'
                                        });
                                    });
                                    $('.drop-related').on('click', function(){

                                    });
                                });
                                function delete_related(object)
                                {
                                    var parent_id = $(object).data('parent_id');
                                    $.ajax({
                                        data: {'id': '{{ $product->id }}', 'parent_id': parent_id},
                                        url: '{{ route("admin.related_product.delete") }}',
                                        type: 'GET',
                                        success: function(response){
                                            $('#related-products').load('{{ route('admin.product.edit', $product) }} #related');
                                        },
                                        dataType: 'json'
                                    });
                                }
                                </script>

                                <div class="form-group">
                                    <label>Voeg gerelateerde producten toe via artikelnummer</label>
                                    <div class="input-group">
                                        <input type="text" name="search_sku" placeholder="Artikelnummer" class="form-control">
                                        <div class="input-group-append">
                                            <a href="javascript:;" class="btn btn-primary add-product">Voeg product toe</a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="h4 mt-4">Gekoppelde producten</h3>
                                <div id="related-products">
                                    <div id="related">
                                        <div class="card-deck">
                                            @foreach ($product->related as $key => $related)
                                                <div class="card col-md-3">
                                                    <div class="pt-2">
                                                        <a href="{{ route('admin.product.edit', $related->product) }}">{{ $related->product->title }}</a><br>
                                                        {{ $related->product->sku }}
                                                    </div>
                                                    <div class="text-right"><a href="javascript:;" onclick="return delete_related($(this))" data-parent_id="{{ $related->parent_id }}">verwijder</a></div>
                                                </div>
                                                {!! $loop->iteration % 3 == 0 && $key != 0 ? '</div><div class="card-deck mt-4">' : '' !!}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <div class="input-group">
                                        <input type="text" name="seo[title]" value="{{ $product->seo['title'] }}" class="form-control" value="">
                                        @include('language.admin.partials.translate', ['field' => 'seo[title]', 'parent_id' => $product->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <div class="input-group">
                                        <textarea name="seo[keywords]" class="form-control">{{ $product->seo['keywords'] }}</textarea>
                                        @include('language.admin.partials.translate', ['field' => 'seo[keywords]', 'parent_id' => $product->id])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <div class="input-group">
                                        <textarea name="seo[description]" class="form-control">{{ $product->seo['description'] }}</textarea>
                                        @include('language.admin.partials.translate', ['field' => 'seo[description]', 'parent_id' => $product->id])
                                    </div>
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
