
@extends('layouts.website')

@section('content')
    <div class="container">
        <h1 class="mt-4">{!! it('shopping-cart-header', 'Winkelwagen') !!}</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrumbs_shopping_cart', 'Winkelwagen') !!}</li>
            </ol>
        </nav>

        <hr>

        @if (Cart::count() > 0)

            <table class="table table-borderless shopping-cart border">
                <thead class="bg-light">
                    <tr>
                        <th>{!! it('cart-product', 'Artikel') !!}</th>
                        <th>{!! it('cart-qty', 'Aantal') !!}</th>
                        <th>{!! it('cart-price', 'Prijs') !!}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                        <tr class="product border-bottom">
                            <td valign="top align-middle">
                                <div class="d-flex">
                                    <div class="image mr-3" style="background-image: url('/storage/{{ @$item->id->assets()->get()->first()->file }}')"></div>
                                    <div class="name">
                                        {{ t($item->id, 'title') }}
                                        @if ($item->id->sku)
                                            <span class="d-block small">{!! it('webshop-product-sku', 'Artikelnummer') !!}: {{ $item->id->sku }}</span>
                                        @endif
                                        @foreach ($item->options as $option => $value)
                                            @php $option = App\Models\ProductVariation::where('slug', $option)->first() @endphp
                                            @php $variation = \App\Models\Variation::find($option->variation_id) @endphp
                                            <span class="d-block small">{{ @t($variation, 'title') }}: {{ $value }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">{{ $item->qty }}</td>
                            <td class="align-middle">&euro; {{ price($item->total) }}</td>
                            <td class="align-middle"><a href="{{ route('cart.delete', $item->rowId) }}"><i class="fas fa-times"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>{!! it('cart-sub-total', 'Sub-totaal') !!}</td>
                        <td>&euro; {{ App\Libraries\Cart::subtotal() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{!! it('cart-shipping', 'Verzendkosten') !!}</td>
                        <td>&euro; {{ App\Libraries\Cart::shipping(true, 2, null, null, App\Libraries\Cart::subtotal(2, '.')) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{!! it('cart-tax', 'BTW (9%)') !!}</td>
                        <td>&euro; {{ App\Libraries\Cart::tax() }}</td>
                        <td></td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td></td>
                        <td>{!! it('cart-total', 'Totaal') !!}</td>
                        <td>&euro; {{ App\Libraries\Cart::total() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="d-flex">
                                <a href="{{ route('webshop') }}" class="btn btn-light">{!! it('cart-continue-shopping', 'Verder winkelen') !!}</a>
                                @if (round(App\Libraries\Cart::total()) >= setting('minimum_order_taking'))
                                    <a href="{{ route('checkout') }}" class="btn btn-green ml-auto">{!! it('cart-to-pay', 'Afrekenen') !!}</a>
                                @else
                                    <p class="ml-auto text-warning">{!! it('cart-minimum', 'Minimaal order afname €') !!} {{ price(setting('minimum_order_taking')) }}</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        @else

            <div class="text-center font-weight-bold mt-4">{!! it('cart-is-empty', 'Er zit niks in je winkelmandje') !!}</div>
            <div class="text-center mt-4"><a href="{{ route('webshop') }}" class="btn btn-green">{!! it('cart-return-to-webshop', 'Ga naar webshop') !!}</a></div>

        @endif

    </div>
@endsection
