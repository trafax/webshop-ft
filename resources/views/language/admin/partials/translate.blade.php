<div class="input-group-append">
    <span class="input-group-text"><a href="javascript:;" onclick="return window.translate()"><i class="far fa-flag"></i></a></span>
</div>

<script type="text/javascript">
window.translate = function(){
    $.ajax({
        url: '{{ route('admin.translate') }}',
        method: 'GET',
        data: {field: '{{ $field }}', parent_id: '{{ $parent_id }}'},
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
