@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Fotoalbums</a></li>
                    <li class="breadcrumb-item active">Fotoalbum aanpassen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Fotoalbum aanpassen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.gallery.update', $gallery) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#images" role="tab" aria-controls="nav-home" aria-selected="true">Foto's</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Titel</label>
                                            <input type="text" name="title" class="form-control" required value="{{ $gallery->title }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="images" role="tabpanel" aria-labelledby="nav-home-tab">
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
                                                                    $('.image-wrapper').load('{{ route('admin.gallery.edit', $gallery) }} .image-container', function(){
                                                                        window.sort();
                                                                    });
                                                                }
                                                            });
                                                        }

                                                        return false;
                                                    }
                                                </script>
                                            <div class="row sortable" data-action="{{ route('admin.asset.sort') }}">
                                                @forelse ($gallery->assets as $asset)
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
                                                        formData.append('parent_id', '{{ $gallery->id }}');
                                                    });
                                                    this.on("complete", function (file) {
                                                        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                                            $('.image-wrapper').load('{{ route('admin.gallery.edit', $gallery) }} .image-container', function(){
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
