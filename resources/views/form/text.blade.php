<div class="col-md-6 my-4 mt-md-0 mb-md-0">
    <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'border inline-editor' : '' }}" data-locale="{{ config('app.locale') }}" data-action="{{ route('admin.text.save_text', $block) }}">
        {!! isset($block->text->first()->content) ? $block->text->first()->content : '' !!}
    </div>
</div>
