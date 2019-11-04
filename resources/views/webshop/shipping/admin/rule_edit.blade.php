<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.rule.update', $shipping_rule->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Verzendregel aanpassen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Land</label>
                                <select class="form-control" name="country_id">
                                    @foreach ($countries as $country)
                                        <option {{ $shipping_rule->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <label>Prijs</label>
                            <input type="text" name="price" value="{{ $shipping_rule->price }}" class="form-control">
                        </div>
                        <div class="col">
                            <label>Gratis vanaf</label>
                            <input type="text" name="free_from" value="{{ $shipping_rule->free_from }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
