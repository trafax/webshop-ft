@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Afrekenen</li>
            </ol>
        </nav>

        <hr>

        <form method="post" action="">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h4">Klantgegevens</h2>
                    <hr>
                    <div class="form-group">
                        <label class="font-weight-bold">Naam</label>
                        <span class="d-block">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Adres</label>
                        <span class="d-block">{{ Auth::user()->customer->address }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Postcode + Plaats</label>
                        <span class="d-block">{{ Auth::user()->customer->zipcode }} {{ Auth::user()->customer->city }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Land</label>
                        <span class="d-block">{{ Auth::user()->customer->country }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Telefoonnummer</label>
                        <span class="d-block">{{ Auth::user()->customer->telephone }}</span>
                    </div>
                    <p>
                        Kloppen uw gegevens niet?<br><a href="{{ route('customer.edit') }}">Pas ze hier aan.</a>
                    </p>
                </div>

                <div class="col-md-4">
                    <h2 class="h4">Betaalgegevens</h2>
                    <hr>
                    @foreach ($payment_methods as $key => $method)
                        <div style="line-height:40px; vertical-align:top">
                            <label class="pointer">
                                <input type="radio" name="payment_method" value="{{ $method->id }}" {{ $key == 0 ? 'checked' : '' }} class="mr-2">
                                <img src="{{ htmlspecialchars($method->image->size1x) }}" srcset="{{ htmlspecialchars($method->image->size2x) }} 2x" class="mr-2">
                                {{ htmlspecialchars($method->description) }} ({{ htmlspecialchars($method->id) }})
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <h2 class="h4">Winkelwagen</h2>
                    <hr>
                    @foreach (Cart::content() as $item)
                        <div class="border-bottom mb-2 pb-2">
                            <strong class="d-block">{{ t($item->id, 'title') }}</strong>
                            <div class="d-flex">
                                <span>Aantal: {{ $item->qty }}x</span>
                                <span class="ml-auto">&euro; {{ price($item->total) }}</span>
                            </div>
                        </div>
                    @endforeach
                    <div class="mb-2 mt-4 ">
                        <div class="d-flex border-bottom py-1">
                            <span>Sub-totaal</span>
                            <span class="ml-auto">&euro; {{ Cart::subtotal() }}</span>
                        </div>
                        <div class="d-flex border-bottom py-1">
                            <span>Verzendkosten</span>
                            <span class="ml-auto">&euro; 0,00</span>
                        </div>
                        <div class="d-flex border-bottom py-1">
                            <span>BTW (9%)</span>
                            <span class="ml-auto">&euro; {{ Cart::tax() }}</span>
                        </div>
                        <div class="d-flex py-1">
                            <span>Totaal</span>
                            <span class="ml-auto">&euro; {{ Cart::total() }}</span>
                        </div>
                    </div>

                    <p class="mt-3"><label><input type="checkbox" name="agreed" value="1"> Ik plaats een bestelling met betaalplicht en ga akkoord met de <a href="#">algemene voorwaarden</a></label></p>
                    <button type="submit" class="btn btn-green mt-3 float-right">Afrekenen</button>
                </div>
            </div>
        </form>

    </div>
@endsection
