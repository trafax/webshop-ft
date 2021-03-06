<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.parallax.update', $block) }}">
                @method('put')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Afbeelding (parallax) aanpassen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Uiterlijk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Afbeelding</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Weergave</label>
                                        <select name="block_data[container]" class="form-control">
                                            <option value="container-fluid">Volledige breedte</option>
                                            <option value="container" {{ $block->block_data['container'] == 'container' ? 'selected' : '' }}>Niet volledige breedte</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Hoogte (bv. 200px)</label>
                                        <input type="text" name="block_data[height]" value="{{ @$block->block_data['height'] }}" class="form-control">
                                    </div>
                                </div>
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
                                    @if ($block->asset->file)
                                        <img src="{{ asset('/storage/'.$block->asset->file) }}" width="100%">

                                        <a href="{{ route('admin.asset.delete', $block->asset) }}" class="btn btn-danger float-right mt-4">Verwijder afbeelding</a>
                                    @endif
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
