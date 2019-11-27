<div class="form-group">
    <label>{{ t($field, 'title') }}</label>
    <input type="email" name="{{ t($field, 'title') }}" value="{{ old(t($field, 'title')) }}" class="form-control">
    @if ($errors->has(t($field, 'title')))
        <span class="text-danger">{{ ucfirst($errors->first(t($field, 'title'))) }}</span>
    @endif
</div>
