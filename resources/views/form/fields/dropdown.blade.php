<div class="form-group">
    <label>{{ t($field, 'title') }}</label>
    <select name="{{ t($field, 'title') }}" class="form-control">
        @foreach ($field->values as $value)
            <option {{ old(t($field, 'title')) == t($value, 'title') ? 'selected' : '' }} value="{{ t($value, 'title') }}">{{ t($value, 'title') }}</option>
        @endforeach
    </select>
</div>
