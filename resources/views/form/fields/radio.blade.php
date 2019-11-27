<div class="form-group">
    <label>{{ t($field, 'title') }}</label>
    @foreach ($field->values as $key => $value)
        <div class="form-check">
            <input class="form-check-input" name="{{ t($field, 'title') }}" type="radio" value="{{ t($value, 'title') }}" id="{{ $value->id }}" {{ $key == 0 ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $value->id }}">
                {{ t($value, 'title') }}
            </label>
        </div>
    @endforeach
</div>
