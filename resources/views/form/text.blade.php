<div class="col-md-6 my-4 mt-md-0 mb-md-0">
    <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'border inline-editor' : '' }}" data-locale="{{ config('app.locale') }}" data-action="{{ route('admin.text.save_text', $block) }}">
        @php $translation = \App\Models\Translation::where(['parent_id' => $block->id, 'field' => 'col_'])->where('language_key', config('app.locale'))->first(); @endphp
        {!! isset($translation) ? $translation->value : $block->text->first()->content !!}
    </div>
</div>
