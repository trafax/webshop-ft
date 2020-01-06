@php
$function = uniqid('_1');
@endphp

<div class="input-group-append">
    <span class="input-group-text"><a href="javascript:;" onclick="return window.translate_{{ $function }}()"><i class="far fa-flag"></i></a></span>
</div>

<script type="text/javascript">
window.translate_{{ $function }} = function(){
    $.ajax({
        url: '{{ route('admin.translate') }}',
        method: 'GET',
        //data: {field: '{{ $field }}', parent_id: '{{ $parent_id }}', editor: '{{ isset($editor) && $editor ? true : false }}'},
        data: {field: '{{ $field }}', parent_id: '{{ $parent_id }}', editor: '{{ isset($editor) ? $editor : false }}', tab: window.location.hash},
        success: function(response)
        {
            $('body').prepend(response);
            $('.modal').modal('show');

            $('.modal').on('hidden.bs.modal', function (e) {
                $('.modal').remove();
            });
        }
    });
};
</script>
