@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Product bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('product.update', $product) }}">
                        @method('PUT')
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="nav-profile" aria-selected="false">Categorieën</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#images" role="tab" aria-controls="nav-profile" aria-selected="false">Afbeeldingen</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Zoekmachine</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label>Productnaam</label>
                                    <input type="text" name="title" value="{{ $product->title }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Link <small>optioneel</small></label>
                                    <input type="text" name="slug" value="{{ $product->slug }}" class="form-control">
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
                                                                    $('.image-wrapper').load('{{ route('product.edit', $product) }} .image-container', function(){
                                                                        window.sort();
                                                                    });
                                                                }
                                                            });
                                                        }

                                                        return false;
                                                    }
                                                </script>
                                            <div class="row sortable" data-action="{{ route('asset.sort') }}">
                                                @forelse ($product->assets as $asset)
                                                    <div class="col-md-3 mb-3" id="{{ $asset->id }}">
                                                        <div class="thumb" style="background-image: url('/storage/{{ $asset->file }}');">
                                                            <a href="javascript:;" onclick="return delFile('{{ route('asset.delete', $asset) }}')" class="stretched-link">X</a>
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
                                                url: '{{ route('asset.upload') }}',
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
                                                            $('.image-wrapper').load('{{ route('product.edit', $product) }} .image-container', function(){
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
                            <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <input type="text" name="seo[title]" value="{{ $product->seo['title'] }}" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label>Pagina zoekwoorden</label>
                                    <textarea name="seo[keywords]" class="form-control">{{ $product->seo['keywords'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Pagina omschrijving</label>
                                    <textarea name="seo[description]" class="form-control">{{ $product->seo['description'] }}</textarea>
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
