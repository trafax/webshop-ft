<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h1>{{ $gallery->title }}</h1>
        </div>
    </div>

    <div class="row gallery">
        <div class="col-md-7">
            <a href="/storage/{{ $gallery->assets->first()->file }}" data-fancybox="images"><img src="/storage/{{ $gallery->assets->first()->file }}" class="main-image"></a>
        </div>
        <div class="col-md-5">
            @foreach ($gallery->assets as $key => $asset)
            @if ($key > 0)
                <a href="/storage/{{ $asset->file }}" data-fancybox="images" style="background-image: url('/storage/{{ $asset->file }}');" class="gallery-thumb"><img src="/storage/{{ $asset->file }}" class="d-none"></a>
            @endif
            @endforeach
        </div>
    </div>

    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            {{-- <a href="javascript:;" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a> --}}
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
