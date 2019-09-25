<div class="input-group form-group">
    <input class="form-control" type="text" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}">
    <div class="input-group-append">
        <div class="input-group-text">
            <a id="input_{{ $name }}" data-input="{{ $name }}" href="javascript:;" class="text-decoration-none">
                Selecteer
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#input_{{ $name }}').filemanager('{{ $type }}');
    })
</script>
