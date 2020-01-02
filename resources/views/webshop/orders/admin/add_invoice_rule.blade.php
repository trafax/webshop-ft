<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Factuurregel toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.order.store_invoice_rule', $request->get('order_id')) }}">
                    @csrf
                    <div class="form-group">
                        <label>Artikelnummer</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">Product toevoegen aan bestelling</button>
                </form>
            </div>
        </div>
    </div>
</div>
