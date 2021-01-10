<div class="container my-4">

    <h2 class="mt-4">{!! it('homepage-zoeken-' . $block->id, 'Zoeken in de website') !!}</h2>
    <form method="post" action="{{ route('product.search') }}">
        @csrf
        <div class="form-group py-4">
            <div class="input-group">
                <input type="text" name="search" placeholder="{!! t_raw('webshop-search-placeholder', 'Zoek een product...') !!}" class="form-control py-4">
                <div class="input-group-append">
                    <span class="input-group-text"><button class="bg-transparent border-0"><i class="fas fa-search"></i></button></span>
                </div>
                @if (Auth::user() && Auth::user()->role == 'admin')
                    {!! it('webshop-search-placeholder','Zoek een product...') !!}
                @endif
            </div>
        </div>
    </form>
    <hr>

    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            {{-- <a href="javascript:;" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a> --}}
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
            <script type="text/javascript">
                function edit_block_{{ $uniq_id }}() {
                    $.ajax({
                        url: '{{ route('admin.featured.edit', $block) }}',
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
