<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.translate.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Vertalen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @foreach (\App\Models\Language::where('is_default', 0)->orderBy('sort')->get() as $key => $language)
                            <a class="nav-item nav-link {{ $key == 0 ? 'active' : '' }}" id="nav-home-tab" data-toggle="tab" href="#{{ $language->language }}" role="tab" aria-controls="nav-home" aria-selected="true">{{ $language->title }}</a>
                        @endforeach
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach (\App\Models\Language::where('is_default', 0)->orderBy('sort')->get() as $key => $language)
                            <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="{{ $language->language }}" role="tabpanel" aria-labelledby="nav-home-tab">
                                <input type="text" name="translate[{{ $language['language_key'] }}]" value="{{ t(request()->get('parent_id'), request()->get('field'), $language->language_key) }}" class="form-control mt-4" placeholder="{{ $language->title }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') }}">
                    <input type="hidden" name="field" value="{{ request()->get('field') }}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
