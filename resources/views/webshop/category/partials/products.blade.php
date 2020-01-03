@if ($products->isNotEmpty())
    <div class="card-deck products">
        @foreach ($products as $key => $product)
        <div class="card product mb-4">
            @if ($product->status)
                <div class="sold-message">{!! t($product, 'status') !!}</div>
            @endif
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
        {!! ($key+1) % (isset($cols_per_row) ? $cols_per_row : 3) == 0 ? '</div><div class="card-deck products">' : '' !!}
        @endforeach
    </div>
@endif
