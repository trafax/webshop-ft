<div class="container my-4">
    <div class="row row-eq-height">
        @for ($i=1; $i<=$block->block_data['cols']; $i++)
            @php
                $style = isset($block->block_data['col_'.$i.'_padding']) ? 'padding: '.$block->block_data['col_'.$i.'_padding'].';' : '';
                $style .= isset($block->block_data['col_'.$i.'_bg_color']) ? 'background-color: '.$block->block_data['col_'.$i.'_bg_color'].';' : '';
            @endphp
            <div class="col-lg col-md-6 col-sm-12 ">
                <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'border inline-editor' : '' }}" style="{!! $style !!}" data-locale="{{ config('app.locale') }}" data-col="{{ $i }}" data-action="{{ route('admin.text.save_text', $block) }}">
                    {!! isset($content[$i]) ? $content[$i] : '' !!}
                </div>
            </div>
        @endfor
    </div>
    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            <a href="javascript:;" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a>
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
            <script type="text/javascript">
                function edit_block_{{ $uniq_id }}() {
                    $.ajax({
                        url: '{{ route('admin.text.edit', $block) }}',
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
