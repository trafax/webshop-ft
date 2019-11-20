<div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.text.update', $block) }}">
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tekstblok aanpassen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Weergave</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#layout" role="tab" aria-controls="profile" aria-selected="false">Layout</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="form-group">
                                    <label>Aantal kolommen</label>
                                    <select name="block_data[cols]" class="form-control">
                                        @for ($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}" {{ $block->block_data['cols'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="layout" role="tabpanel" aria-labelledby="home-tab">
                                @for ($i=1; $i<=$block->block_data['cols'] == $i; $i++)
                                    <div class="row">
                                        <div class="col">
                                            @include ('partials.colorpicker', ['name' => 'block_data[col_'.$i.'_bg_color]', 'title' => 'Kleur kolom '.$i, 'value' => @$block->block_data['col_'.$i.'_bg_color']])
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Padding kolom {{ $i }}</label>
                                                <input class="form-control" type="text" name="block_data[col_{{ $i }}_padding]" value="{{ @$block->block_data['col_'.$i.'_padding'] }}">
                                            </div>
                                        </div>
                                    </div>
                                @endfor
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
