<div class=" {{ ($block->block_data['container'] ?? '') == 'container' ? 'container' : '' }} my-4" style="cursor: pointer">

    <div id="carousel" class="carousel slide" data-ride="carousel" style="height: {{ @$block->block_data['image_height'] }};">
        <ol class="carousel-indicators">
            @foreach($block->assets as $key => $asset)
                <li data-target="#carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($block->assets()->get() as $key => $asset)
                <div class="carousel-item main-image {{ $key == 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$asset->file) }}'); background-size: cover; background-position: center; height: {{ @$block->block_data['image_height'] }};">
                    <a href="{{ $asset->file_data['link'] ?? '' }}" class="stretched-link"></a>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    {{-- <div style="height: {{ @$block->block_data['image_height'] }}; background-image: url(/storage/{{ @$block->asset->file }}); background-size: cover; background-position: center;"></div> --}}
    {{-- <h2 class="mt-3 text-center">{{ @$block->block_data['title'] }}</h2> --}}
    {{-- <p>
        {!! it('advertention-text-'. $block->id, '', true) !!}
    </p> --}}

    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions" style="z-index: 999;">
            @php $uniq_id = uniqid('_1') @endphp
            <a href="javascript:;" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a>
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
            <script type="text/javascript">
                function edit_block_{{ $uniq_id }}() {
                    $.ajax({
                        url: '{{ route('admin.advertention.edit', $block) }}',
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
