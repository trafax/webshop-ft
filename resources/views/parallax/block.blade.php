@php
$style = isset($block->block_data['height']) ? 'height: '. $block->block_data['height'] : '';
@endphp

<div class="{{ $block->block_data['container'] }}">
    <div class="row">
       <div class="{{ $block->block_data['container'] == 'container' ? 'col' : '' }}" style="{!! $style !!}">
           PARALLAX
        </div>
    </div>
    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            <a href="#" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a>
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
            <script type="text/javascript">
                function edit_block_{{ $uniq_id }}() {
                    $.ajax({
                        url: '{{ route('admin.parallax.edit', $block) }}',
                        data: '',
                        method: 'get',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('body').prepend(response);
                            $('.modal').modal('show');

                            $('.modal').on('hidden.bs.modal', function (e) {
                                $('.modal').remove();
                            });
                        }
                    });
                }
                function delete_block_{{ $uniq_id }}() {
                    if (! confirm('Blok verwijderen?')) {
                        return false;
                    }
                }
            </script>
        </div>
    @endif
</div>
