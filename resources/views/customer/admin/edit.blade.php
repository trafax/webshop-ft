@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Klanten</a></li>
                    <li class="breadcrumb-item active">Klant bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Klant bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.customer.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="nav-home" aria-selected="true">Bestellingen</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Voornaam *</label>
                                            <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Tussenvoegsel</label>
                                            <input type="text" name="preposition" value="{{ $user->preposition }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Achternaam *</label>
                                            <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Straatnaam *</label>
                                    <input type="text" name="street" value="{{ $user->customer->street }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Huisnummer *</label>
                                    <input type="text" name="number" value="{{ $user->customer->number }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Postcode *</label>
                                    <input type="text" name="zipcode" value="{{ $user->customer->zipcode }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Plaats *</label>
                                    <input type="text" name="city" value="{{ $user->customer->city }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Land *</label>
                                    <select name="language_key" class="form-control">
                                        @foreach (App\Models\Country::get() as $country)
                                            <option value="{{ $country->language_key }}">{{ t($country, 'title') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Telefoonnummer</label>
                                    <input type="tel" name="telephone" value="{{ $user->customer->telephone }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">E-mailadres *</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="orders" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="border-top-0">Nr</th>
                                            <th scope="col" class="border-top-0">Datum</th>
                                            <th scope="col" class="border-top-0">Prijs</th>
                                            <th scope="col" class="border-top-0">Betaling</th>
                                            <th scope="col" class="border-top-0">Status</th>
                                            <th scope="col" class="border-top-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->orders as $order)
                                            @php $order = $order->order; @endphp
                                            <tr class="{{ @$order->status == 'pending' ? 'text-info' : '' }} {{ @$order->status == 'paid' ? 'text-success' : '' }} {{ in_array(@$order->status, ['error', 'expired', 'failed', 'canceled']) ? 'text-danger' : '' }}">
                                                <td><a href="{{ route('admin.order.show', $order) }}">{{ $order->nr }}</a></td>
                                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                                <td>€ {{ price($order->total) }}</td>
                                                <td>{{ @$order->status }}</td>
                                                <td>{{ $order->order_status ? $order->order_status : ' - ' }}</td>
                                                <td class="text-right">
                                                    @if ($order->status == 'paid')
                                                        <a href="{{ route('admin.order.download_invoice', $order) }}">download</a> |
                                                    @endif
                                                    <a href="{{ route('admin.order.show', $order) }}">bekijk</a>
                                                    {{-- <a href="{{ route('admin.order.destroy', $order) }}" onclick="return confirm('Bestelling verwijderen?')">verwijder</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
