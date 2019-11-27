<div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.form.block.update', $block) }}">
                    @method('put')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Blok aanpassen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Basis</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Toon tekstblok naast formulier</label>
                                            <select name="block_data[text]" class="form-control">
                                                <option value="">Geen</option>
                                                <option value="left" {{ @$block->block_data['text'] == 'left' ? 'selected' : '' }}>Links van formulier</option>
                                                <option value="right" {{ @$block->block_data['text'] == 'right' ? 'selected' : '' }}>Rechts van formulier</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="block_data[form_id]" value="{{ $block->block_data['form_id'] }}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
