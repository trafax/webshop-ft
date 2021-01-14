<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.advertention.update', $block) }}">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Advertentie blok aanpassen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Algemeen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Advertenties</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group">
                                <label>Titel blok</label>
                                <input type="text" name="block_data[title]" class="form-control" required value="{{ @$block->block_data['title'] }}">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Hoogte afbeelding</label>
                                        <input type="text" name="block_data[image_height]" class="form-control" placeholder="Bv. 100px" required value="{{ @$block->block_data['image_height'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Weergave</label>
                                <select name="block_data[container]" class="form-control">
                                    <option value="container-fluid">Volledige breedte</option>
                                    <option value="container" {{ ($block->block_data['container'] ?? '') == 'container' ? 'selected' : '' }}>Niet volledige breedte</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <script type="text/javascript">
                                    $("div.dropzone").dropzone({
                                            url: '{{ route('admin.asset.upload') }}',
                                            dictDefaultMessage: '- Sleep uw bestanden hierin om deze to uploaden -',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            init: function() {
                                                this.on("sending", function(file, xhr, formData){
                                                    formData.append('parent_id', '{{ $block->id }}');
                                                });
                                                this.on("complete", function (file) {
                                                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                    <div class="dropzone" id="customDropzone"></div>

                                </div>
                                <div class="col-md-6">
                                    @forelse ($block->assets as $asset)
                                        <div class="mb-3" id="{{ $asset->id }}">
                                            <div class="thumb" style="background-image: url('/storage/{{ $asset->file }}'); width: 100%; height: 200px; background-suize: cover; background-position: center;">
                                                <a href="javascript:;" onclick="return delFile('{{ route('admin.asset.delete', $asset) }}')">X</a>
                                            </div>
                                            <script>
                                                $(function(){
                                                    $('[id="title_{{ $asset->id }}"]').on('change', function(){
                                                        $.ajax({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            type: "post",
                                                            url: "/admin/asset/update",
                                                            data: {id: $(this).data('id'), "file_data[link]": $(this).val()},
                                                            dataType: "json",
                                                            success: function (response) {
                                                                alert('done');
                                                            }
                                                        });
                                                    })
                                                })
                                            </script>
                                            <input type="text" data-id="{{ $asset->id }}" id="title_{{ $asset->id }}" name="file_data[link]" class="form-control" placeholder="Eventuele link" value="{{ $asset->file_data['link'] ?? '' }}">
                                        </div>
                                    @empty
                                        <p class="col mb-3">Er zijn nog geen afbeeldingen geupload.</p>
                                    @endempty

                                    {{-- @if ($block->asset->file)
                                        <img src="{{ asset('/storage/'.$block->asset->file) }}" width="100%">

                                        <a href="{{ route('admin.asset.delete', $block->asset) }}" class="btn btn-danger float-right mt-4">Verwijder afbeelding</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
