@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Klanten</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Klanten</span>
                    <a href="{{ route('admin.customer.create') }}">Klant toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="border-top-0">Klantnaam</th>
                                <th scope="col" class="border-top-0">Aantal bestellingen</th>
                                <th scope="col" class="border-top-0">Totaal betaald <small>(zonder verzendkosten)</small></th>
                                <th scope="col" class="border-top-0 text-right">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td><a href="{{ route('admin.customer.edit', $customer) }}">{{ $customer->firstname }} {{ $customer->preposition }} {{ $customer->lastname }}</a></td>
                                    <td>{{ $customer->orders->count() }}</td>
                                    @php
                                    $total = $customer->orders->sum(function($order){
                                        if (@$order->order->status == 'paid') {
                                            return $order->rules->sum('price');
                                        }
                                    });
                                    @endphp
                                    <td>&euro; {{ price($total) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.customer.destroy', $customer) }}" onclick="return confirm('Klant verwijderen?')">verwijder</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
