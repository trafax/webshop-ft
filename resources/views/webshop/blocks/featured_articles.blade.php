<div class="container my-4">

    <h2>{{ $block->block_data['title'] }}</h2>

    <div class="card-deck products">
        @forelse ($products as $key => $product)
            <div class="card product mb-4">
                @if ($product->sold_out == 1)
                    <div class="sold-out">{!! it('product-sold-out', 'Uitverkocht') !!}</div>
                @endif
                @if ($product->assets()->get()->first())
                    <div class="image" style="background-image: url('/storage/{{ $product->assets()->get()->first()->file }}')"></div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ t($product, 'title') }}</h5>
                    <a href="{{ route('product', $product->slug) }}" class="stretched-link"></a>
                </div>
            </div>
            {!! ($key+1) % 4 == 0 ? '</div><div class="card-deck products">' : '' !!}
        @empty
            <p class="m-3">{{ it('block-no-products-found', 'Geen artikelen beschikbaar.') }}</p>
        @endforelse
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
