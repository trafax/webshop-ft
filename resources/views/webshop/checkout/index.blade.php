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

        <form method="post" action="{{ route('checkout.place_order') }}">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h4">Factuur / Afleveradres</h2>
                    <hr>
                    <div class="form-group">
                        <label class="font-weight-bold">Naam</label>
                        <span class="d-block">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Adres</label>
                        <span class="d-block">{{ Auth::user()->customer->street }} {{ Auth::user()->customer->number }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Postcode + Plaats</label>
                        <span class="d-block">{{ Auth::user()->customer->zipcode }} {{ Auth::user()->customer->city }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Land</label>
                        <span class="d-block">{{ t(Auth::user()->customer->country()->first(), 'title') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Telefoonnummer</label>
                        <span class="d-block">{{ Auth::user()->customer->telephone }}</span>
                    </div>

                    <div class="mt-2 {!! Auth::user()->customer->other_delivery == 0 ? 'd-none' : '' !!}" id="deliver_address">
                        <h2 class="h4 mt-4">Afwijkend afleveradres</h2>
                        <hr>
                        <div class="bg-light p-3">
                            <div class="form-group">
                                <label class="font-weight-bold">Adres</label>
                                <span class="d-block">{{ Auth::user()->customer->delivery_street }} {{ Auth::user()->customer->delivery_number }}</span>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Postcode + woonplaats</label>
                                <span class="d-block">{{ Auth::user()->customer->delivery_zipcode }} {{ Auth::user()->customer->delivery_city }}</span>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Land</label>
                                <span class="d-block">{{ t(Auth::user()->customer->delivery_country()->first(),'title') }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
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

                    <div class="form-group mt-4">
                        <label class="font-weight-bold">Opmerkingen</label>
                        <p>Vul hier uw eventuele opmerking in</p>
                        <textarea name="comment" class="form-control"></textarea>
                    </div>
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
                            <span class="ml-auto">&euro; {{ App\Libraries\Cart::subtotal() }}</span>
                        </div>
                        <div class="d-flex border-bottom py-1">
                            <span>Verzendkosten</span>
                            <span class="ml-auto">&euro; {{ App\Libraries\Cart::shipping(true) }}</span>
                        </div>
                        <div class="d-flex border-bottom py-1">
                            <span>BTW (9%)</span>
                            <span class="ml-auto">&euro; {{ App\Libraries\Cart::tax() }}</span>
                        </div>
                        <div class="d-flex py-1">
                            <span>Totaal</span>
                            <span class="ml-auto">&euro; {{ App\Libraries\Cart::total() }}</span>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if (session('order_id'))
                        <input type="hidden" name="agreed" value="1">
                        <p class="text-warning">De bestelling is al geplaatst. Deze dient enkel nog betaald te worden.</p>
                        <button type="submit" class="btn btn-green mt-3 float-right">Afrekenen</button>
                    @else
                        <p class="mt-3"><label><input type="checkbox" name="agreed" value="1"> Ik plaats een bestelling en ga akkoord met de <a href="/algemene-voorwaarden">algemene voorwaarden</a></label></p>
                        <button type="submit" class="btn btn-green mt-3 float-right mb-4">Afrekenen</button>
                    @endif
                </div>
            </div>
        </form>

    </div>
@endsection
