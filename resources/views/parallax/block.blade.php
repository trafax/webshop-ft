@php
$style = isset($block->block_data['height']) ? 'height: '. $block->block_data['height'] . ';' : '';
//$style .= isset($block->asset->file) ? 'background-image: url(\'/storage/'.$block->asset->file.'\');' : '';
@endphp

<script>
    $(function(){
        var image = document.getElementsByClassName('thumbnail');
        new simpleParallax(image, {
            scale: 1.5,
            delay: .6,
	        transition: 'cubic-bezier(0,0,0,1)'
        });
    });
</script>

<div class="{{ $block->block_data['container'] }}">
    <div class="row parallax" id="parallax">
       <div class="{{ $block->block_data['container'] == 'container' ? 'col' : '' }} w-100" data-depth="0.00" style="{!! $style !!} overflow: hidden;">
            <img class="thumbnail" src="/storage/{{ $block->asset->file }}">
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
