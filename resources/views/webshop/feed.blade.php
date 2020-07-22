@php echo '<?xml version="1.0" encoding="utf-8"?>'; @endphp
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
    <channel>
        <title>Producten feed</title>
        <description></description>
        <link>{{ url('/') }}</link>
        @foreach ($products as $product)
            @if ($product->price > 0)
                <item>
                    <g:id>{{ Str::slug($product->title . ' ' . $product->categories->first()->title) }}</g:id>
                    <title>{{ $product->title }}</title>
                    <description>{{ $product->description }}</description>
                    <link>{{ route('product', $product->slug) }}</link>
                    <g:price>{{ $product->price ? $product->price : '0,01' }} EUR</g:price>
                    <g:condition>new</g:condition>
                    <g:availability>in stock</g:availability>
                    @if ($product->assets()->get()->first()->file ?? null)
                        <g:image_link>{{ site_url('/storage/'. $product->assets()->get()->first()->file ) }}</g:image_link>
                    @endif
                    <g:brand>{{ $product->categories->first()->title }}</g:brand>
                    <g:mpn>{{ $product->sku }}</g:mpn>
                </item>
            @endif
        @endforeach
    </channel>
</rss>
