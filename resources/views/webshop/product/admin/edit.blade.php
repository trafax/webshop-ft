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
                                            <textarea name="description" class="form-control editor" rows="8">{{ $product->description }}</textarea>
                                            @include('language.admin.partials.translate', ['field' => 'description', 'parent_id' => $product->id, 'editor' => true])
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
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Plaats in</label>
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

                                            echo $tree($categories);
                                        @endphp
                                    </select>
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
                                                <div class="form-group">
                                                    @php $text = ''; @endphp
                                                    @foreach ($product->variations->where('title', $variation->title) as $row)
                                                        @php $text .= $row->pivot->title .
                                                        ($row->pivot->fixed_price ? ', '. $row->pivot->fixed_price : '') .
                                                        ($row->pivot->adding_price ? ', '. $row->pivot->adding_price : '') . "\n"
                                                        @endphp
                                                    @endforeach
                                                    <textarea name="variations[{{ $variation->id }}]" rows="8" class="form-control" placeholder="naam, vaste prijs, meerprijs">{{ $text }}</textarea>
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
