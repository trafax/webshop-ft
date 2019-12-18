<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.featured.update', $block) }}">
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
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Algemeen</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-4" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="form-group">
                                <label>Titel blok</label>
                                <input type="text" name="block_data[title]" class="form-control" required value="{{ @$block->block_data['title'] }}">
                            </div>
                            <div class="form-group">
                                <label>Sorteren producten</label>
                                <select name="block_data[sort_by]" class="form-control">
                                    <option value="rand">Sorteer willekeurig</option>
                                    <option value="title" {{ @$block->block_data['sort_by'] == 'title' ? 'selected' : '' }}>Sorteer alfabetisch</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Toon aantal artikelen</label>
                                <input type="number" name="block_data[total_products]" value="{{ @$block->block_data['total_products'] }}" class="form-control">
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
