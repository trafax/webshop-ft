@extends('layouts.website')

@section('content')
    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{!! it('breadcrumbs_home', 'Home') !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">{!! it('breadcrumbs_webshop', 'Webshop') !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! it('breadcrumbs_my_details', 'Mijn gegevens') !!}</li>
            </ol>
        </nav>

        <hr>


        <form method="post" action="{{ route('customer.update') }}">
                <h2>{!! it('my-details', 'Mijn gegevens') !!}</h2>
                {!! it('my-details-description', '<p>Vul onderstaand uw persoonlijke gegevens in.</p>', true) !!}
                <hr>
            <div class="row">
                <div class="col-md-3">
                    @include('webshop.partials.fast_menu')
                </div>
                <div class="col-md-9">

                    <h2>{!! it('delivery-address', 'Afleveradres') !!}</h2>
                    {!! it('select-when-delivery', '<p>Selecteer wanneer u uw bestelling op een ander adres wilt laten afleveren.</p>', true) !!}
                    <hr>

                    <label class="bg-light d-block py-2 px-3">
                        <input type="hidden" name="other_delivery" value="0">
                        <input type="checkbox" name="other_delivery" value="1" {!! $user->customer->other_delivery == 1 ? 'checked' : '' !!} onclick="$('#deliver_address').toggleClass('d-none')" class="mr-2"> Verzend bestelling naar een ander adres
                    </label>

                    <div class="card mb-4 {!! $user->customer->other_delivery == 0 ? 'd-none' : '' !!}" id="deliver_address">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('delivery_street', 'Straatnaam') !!}</label>
                                <input type="text" name="delivery_street" value="{{ $user->customer->delivery_street }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('delivery_number', 'Huisnummer') !!}</label>
                                <input type="text" name="delivery_number" value="{{ $user->customer->delivery_number }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('delivery_zipcode_city', 'Postcode + woonplaats') !!}</label>
                                <div class="row">
                                    <div class="col-md-4"><input type="text" name="delivery_zipcode" value="{{ $user->customer->delivery_zipcode }}" class="form-control"></div>
                                    <div class="col-md-8"><input type="text" name="delivery_city" value="{{ $user->customer->delivery_city }}" class="form-control"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('delivery_country', 'Land') !!} *</label>
                                <select name="delivery_language_key" class="form-control">
                                    @foreach (App\Models\Country::get() as $country)
                                        <option value="{{ $country->language_key }}" {!! $user->customer->delivery_language_key == $country->language_key ? 'selected' : '' !!}>{{ t($country, 'title') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <h2 class="mt-4">{!! it('invoice_details', 'Factuurgegevens') !!}</h2>
                    {!! it('invoice_details_description', '<p>Vul onderstaand uw persoonlijke adresgegevens in.</p>', true) !!}
                    <hr>

                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_name', 'Naam') !!} *</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_street', 'Straatnaam') !!} *</label>
                                <input type="text" name="street" value="{{ $user->customer->street }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_number', 'Huisnummer') !!} *</label>
                                <input type="text" name="number" value="{{ $user->customer->number }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_zipcode', 'Postcode') !!} *</label>
                                <input type="text" name="zipcode" value="{{ $user->customer->zipcode }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_city', 'Plaats') !!} *</label>
                                <input type="text" name="city" value="{{ $user->customer->city }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_country', 'Land') !!} *</label>
                                <select name="language_key" class="form-control">
                                    @foreach (App\Models\Country::get() as $country)
                                        <option value="{{ $country->language_key }}" {!! $user->customer->language_key == $country->language_key ? 'selected' : '' !!}>{{ t($country, 'title') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_telephone', 'Telefoonnummer') !!}</label>
                                <input type="text" name="telephone" value="{{ $user->customer->telephone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">{!! it('invoice_email', 'E-mailadres') !!} *</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    @if (session('message'))
                        <div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> {!! it('your_details_saved', session('message')) !!}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning" role="alert"><i class="far fa-check-circle"></i> {!! it('your_details_error', session('error')) !!}</div>
                    @endif

                    <div class="form-group d-flex mt-4">
                        <button type="submit" class="btn btn-green mr-3">{!! it('profile_save', 'Sla mijn gegevens op') !!}</button>

                        @if (Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
                            <a href="{{ route('checkout') }}" class="btn btn-light">{!! it('continue_shopping', 'Ga verder met bestellen') !!}</a>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
