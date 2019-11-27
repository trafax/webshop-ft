<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.form_field.store') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Veld toevoegen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Titel</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control">
                                    <option value="text">Tekstregel</option>
                                    <option value="email">E-mail</option>
                                    <option value="dropdown">Uitklapvenster</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Vinkjes</option>
                                    <option value="textarea">Tekstregels</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Verplicht</label>
                                <select name="required" class="form-control">
                                    <option value="0">Nee</option>
                                    <option value="1">Ja</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="parent_id" value="{{ $request->get('parent_id') }}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>
