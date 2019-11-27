<div class="form-group">
    <label>{{ t($field, 'title') }}</label>
    @foreach ($field->values as $value)
        <div class="form-check">
            <input class="form-check-input" name="{{ str_slug(t($field, 'title'), '_') }}[]" {{ @in_array(t($value, 'title'), old(str_slug(t($field, 'title'), '_'))) ? 'checked' : '' }} type="checkbox" value="{{ t($value, 'title') }}" id="{{ $value->id }}">

            <label class="form-check-label" for="{{ $value->id }}">
                {{ t($value, 'title') }}
            </label>
        </div>
    @endforeach
    @if ($errors->has(str_slug(t($field, 'title'), '_')))
        <span class="text-danger">{{ ucfirst($errors->first(str_slug(t($field, 'title'), '_'))) }}</span>
    @endif
</div>
