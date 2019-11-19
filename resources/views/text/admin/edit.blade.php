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
                        <select name="block_data[cols]" class="form-control">
                            <option value="1">Aantal kolommen</option>
                            @for ($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $block->block_data['cols'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
