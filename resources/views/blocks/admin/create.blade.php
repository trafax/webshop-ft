<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Blok toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tekstblok</h5>
                            <form method="post" action="{{ route('admin.block.store') }}">
                                @csrf
                                <p class="card-text">Dit blok creëert een mogelijkheid tot het plaatsen van tekst in de beschikbare kolommen.</p>
                                <div class="d-inline float-left mr-2">
                                    <select name="block_data[cols]" class="form-control">
                                        <option value="1">Aantal kolommen</option>
                                        @for ($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $request->get('parent_id') }}">
                                <input type="hidden" name="type" value="text">
                                <button class="btn btn-primary" type="submit">Plaats blok</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Afbeelding (parallax)</h5>
                            <form method="post" action="{{ route('admin.block.store') }}">
                                @csrf
                                <p class="card-text">Dit blok creëert een mogelijkheid om een foto te uploaden die een scroll effect toont.</p>
                                <div class="d-inline float-left mr-2">
                                    <select name="block_data[container]" class="form-control">
                                        <option value="container-fluid">Volledige breedte</option>
                                        <option value="container">Niet volledige breedte</option>
                                    </select>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $request->get('parent_id') }}">
                                <input type="hidden" name="type" value="parallax">
                                <button class="btn btn-primary" type="submit">Plaats blok</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-deck mt-1">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Formulier</h5>
                            <form method="post" action="{{ route('admin.block.store') }}">
                                @csrf
                                <p class="card-text">Dit blok toont het geselecteerde formulier.</p>
                                <div class="d-inline float-left mr-2">
                                    <select name="block_data[form_id]" class="form-control">
                                        @foreach (\App\Models\Form::all() as $form)
                                            <option value="{{ $form->id }}">{{ $form->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $request->get('parent_id') }}">
                                <input type="hidden" name="type" value="form">
                                <button class="btn btn-primary" type="submit">Plaats blok</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
            </div>
        </div>
    </div>
</div>
