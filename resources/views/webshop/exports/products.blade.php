<table>
    <thead>
    <tr>
        <th>Sku</th>
        <th>Category</th>
        <th>Title</th>
        <th>Price</th>
        <th>Description</th>
        <th>Seizoen</th>

        @foreach (\App\Models\Variation::all() as $key => $variation)
            <th>{{ $variation->title }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach(\App\Models\Product::all() as $product)
        @if ($product->categories()->count() > 0 && $product->sku)
            <tr>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->categories->where('title', '!=', 'Alle producten')->first()->title ?? '' }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->categories->first()->season == 1 ? 'Zomer' : 'Voorjaar' }}</td>
                @foreach (\App\Models\Variation::all() as $key => $variation)
                    @php $rows = $product->variations->where('title', $variation->title)->where('pivot.sold_out', 0); @endphp
                    @if ($rows->count() > 0)
                    <td>{
                        @foreach ($rows as $row)
                            "{{ $row->pivot->title }}" {{ $row->pivot->fixed_price > 0 ? ': ' . $row->pivot->fixed_price : '' }}{{ $loop->last == false ? ',' : '' }}
                        @endforeach
                    }</td>
                    @endif
                @endforeach
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
