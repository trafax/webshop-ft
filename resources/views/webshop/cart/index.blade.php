
@extends('layouts.website')

@section('content')
    <div class="container">
        <h1 class="mt-4">Winkelwagen</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Winkelwagen</li>
            </ol>
        </nav>

        <hr>

        @if (Cart::count() > 0)

            <table class="table table-borderless shopping-cart border">
                <thead class="bg-light">
                    <tr>
                        <th>Artikel</th>
                        <th>Aantal</th>
                        <th>Prijs</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="product border-bottom">
                            <td valign="top align-middle">
                                <div class="d-flex">
                                    <div class="image mr-3" style="background-image: url('/storage/{{ $item->id->assets()->get()->first()->file }}')"></div>
                                    <span class="name mt-3">{{ t($item->id, 'title') }}</span>
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
                        <td>Sub-totaal</td>
                        <td>&euro; {{ Cart::subtotal() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>BTW (9%)</td>
                        <td>&euro; {{ Cart::tax() }}</td>
                        <td></td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td></td>
                        <td>Totaal</td>
                        <td>&euro; {{ Cart::total() }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="d-flex">
                                <a href="{{ route('webshop') }}" class="btn btn-light">Verder winkelen</a>
                                <a href="{{ route('checkout') }}" class="btn btn-green ml-auto">Afrekenen</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        @else

            <p class="text-center font-weight-bold">Er zit niks in je winkelmandje</p>

        @endif

    </div>
@endsection
