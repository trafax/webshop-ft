@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Bestellingen</li>
                </ol>
            </nav>

            <div class="d-flex mb-2">
                <div>
                    <a href="{{ route('admin.order.create') }}" class="btn btn-primary">Maak bestelling</a>
                </div>
                <div class="ml-auto">
                    {{ $orders->links() }}
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Bestellingen</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="border-top-0">Nr</th>
                                <th scope="col" class="border-top-0">Datum</th>
                                <th scope="col" class="border-top-0">Landcode</th>
                                <th scope="col" class="border-top-0">Prijs</th>
                                <th scope="col" class="border-top-0">Betaling</th>
                                <th scope="col" class="border-top-0">Status</th>
                                <th scope="col" class="border-top-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="{{ $order->status == 'pending' ? 'text-info' : '' }} {{ $order->status == 'paid' ? 'text-success' : '' }} {{ in_array($order->status, ['error', 'expired', 'failed', 'canceled']) ? 'text-danger' : '' }}">
                                    <td><a href="{{ route('admin.order.show', $order) }}">{{ $order->nr }}</a></td>
                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ @strtoupper($order->customer->country) }}</td>
                                    <td>€ {{ price($order->total) }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->order_status ? $order->order_status : ' - ' }}</td>
                                    <td class="text-right">
                                        @if ($order->status == 'paid')
                                            <a href="{{ route('admin.order.download_invoice', $order) }}">download</a> |
                                        @endif
                                        <a href="{{ route('admin.order.show', $order) }}">bekijk</a> |
                                        <a href="{{ route('admin.order.destroy', $order) }}" onclick="return confirm('Bestelling verwijderen?')">verwijder</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex my-3"><div class="ml-auto">{{ $orders->links() }}</div></div>

        </div>
    </div>
</div>
@endsection
