@php $uniqname = uniqid('_1'); @endphp
<script type="text/javascript">
    $('.{{ $uniqname }}').colorpicker({
        format: "rgb"
    });
</script>
<div class="form-group">
    <label>{{ $title }}</label>
    <input class="{{ $uniqname }} form-control" type="text" name="{{ $name }}" value="{!! $value !!}">
</div>
