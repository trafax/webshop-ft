<div class="form-group">
    <label>{{ t($field, 'title') }}</label>
    <textarea name="{{ t($field, 'title') }}" class="form-control" rows="5">{{ old(t($field, 'title')) }}</textarea>
    @if ($errors->has(t($field, 'title')))
        <span class="text-danger">{{ ucfirst($errors->first(t($field, 'title'))) }}</span>
    @endif
</div>
