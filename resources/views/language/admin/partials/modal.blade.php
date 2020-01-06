<div class="modal" tabindex="-1" role="dialog">
    <script>
    $(function(){
        //$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // e.target // newly activated tab
            // e.relatedTarget // previous active tab
            tinymce.init({
                selector: '.editor',
                language: 'nl',
                skin: 'oxide',
                plugins: "link image media",
                convert_urls: 0, toolbar: 'formatselect | fontsizeselect | bold italic strikethrough | link image media'
            });
        //});
    });
    </script>
    <div class="modal-dialog {{ request()->get('editor') == 1 ? 'modal-lg' : '' }}" role="document">
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
                        @php
                            $languageQuery = \App\Models\Language::where('is_default', 0);
                            if (request()->get('enable_default') == 1)
                            {
                                $languageQuery->orWhere('is_default', 1);
                            }
                            $languages = $languageQuery->orderBy('sort')->get();
                        @endphp
                        @foreach ($languages as $key => $language)
                            <a class="nav-item nav-link {{ $key == 0 ? 'active' : '' }}" id="nav-home-tab" data-toggle="tab" href="#{{ $language->language }}" role="tab" aria-controls="nav-home" aria-selected="true">{{ $language->title }}</a>
                        @endforeach
                    </div>
                    <div class="tab-content" id="nav-tabContent">
                        @php
                            $languageQuery = \App\Models\Language::where('is_default', 0);
                            if (request()->get('enable_default') == 1)
                            {
                                $languageQuery->orWhere('is_default', 1);
                            }
                            $languages = $languageQuery->orderBy('sort')->get();
                        @endphp
                        @foreach ($languages as $key => $language)
                            <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="{{ $language->language }}" role="tabpanel" aria-labelledby="nav-home-tab">
                                @if (request()->get('editor') == 'raw')
                                    <br>
                                    <textarea name="translate[{{ $language['language_key'] }}]" class="form-control" rows="8" placeholder="{{ $language->title }}">{{ t(request()->get('parent_id'), request()->get('field'), $language->language_key) }}</textarea>
                                @elseif (request()->get('editor') == true || request()->get('editor') == 1)
                                    <br>
                                    <textarea name="translate[{{ $language['language_key'] }}]" class="editor form-control" placeholder="{{ $language->title }}">{{ t(request()->get('parent_id'), request()->get('field'), $language->language_key) }}</textarea>
                                @else
                                    <input type="text" name="translate[{{ $language['language_key'] }}]" value="{{ t(request()->get('parent_id'), request()->get('field'), $language->language_key) }}" class="form-control mt-4">
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="tab" value="{{ request()->get('tab') }}">
                    <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') }}">
                    <input type="hidden" name="field" value="{{ request()->get('field') }}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluit</button>
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
