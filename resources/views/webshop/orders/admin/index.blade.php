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
                    <div class="row w-50">
                        <div class="col-6">
                            <form method="post" action="{{ route('admin.order.search') }}">
                                @csrf
                                <input type="text" name="search" placeholder="Zoek bestelling" class="form-control">
                            </form>
                        </div>
                        <div class="col-6">
                            <script type="text/javascript">
                                $(function(){
                                    $('.status').on('change', function(){
                                        var value = $('.status').val();
                                        window.location.href = '/admin/order/' + encodeURIComponent(value);
                                    });
                                });
                            </script>
                            <select class="form-control status">
                                <option value="">Filter op status</option>
                                <option value="">Alle bestellingen</option>
                                <option value="Is betaald" {{ $status == 'Is betaald' ? 'selected' : '' }}>Is betaald</option>
                                <option value="In behandeling" {{ $status == 'In behandeling' ? 'selected' : '' }}>In behandeling</option>
                                <option value="Verzonden en voltooid" {{ $status == 'Verzonden en voltooid' ? 'selected' : '' }}>Verzonden en voltooid</option>
                                <option value="Geannuleerd" {{ $status == 'Geannuleerd' ? 'selected' : '' }}>Geannuleerd</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="border-top-0">Nr</th>
                                <th scope="col" class="border-top-0">Datum</th>
                                <th scope="col" class="border-top-0">Klant</th>
                                <th scope="col" class="border-top-0">Landcode</th>
                                <th scope="col" class="border-top-0">Prijs</th>
                                <th scope="col" class="border-top-0">Betaling</th>
                                <th scope="col" class="border-top-0">Status</th>
                                <th scope="col" class="border-top-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($orders as $order)
                                @php $total = $total + $order->total; @endphp
                            <tr class="order_rule {{ ($order->status ?? '') == 'pending' ? 'text-info' : '' }} {{ ($order->status ?? '') == 'paid' ? 'text-success' : '' }} {{ in_array(($order->status ?? ''), ['error', 'expired', 'failed', 'canceled']) ? 'text-danger' : '' }}" data-status="{{ @$order->order_status ?? '' }}">
                                    <td><a href="{{ route('admin.order.show', $order) }}">{{ $order->nr }}</a></td>
                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $order->customer->firstname ?? '' }} {{ $order->customer->preposition ?? '' }} {{ $order->customer->lastname ?? '' }}</td>
                                    <td>{{ @strtoupper($order->customer->language_key) }}</td>
                                    <td>€ {{ price($order->total) }}</td>
                                    <td>{{ ($order->status ?? '') }}</td>
                                    <td>{{ ($order->order_status ?? NULL) ? $order->order_status : ' - ' }}</td>
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
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="2" class="text-right">Aantal</td>
                                <td><?php echo count($orders) ?></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td colspan="2" class="text-right">Totaal</td>
                                <td>&euro; <?php echo price($total) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex my-3"><div class="ml-auto">{{ $orders->links() }}</div></div>

        </div>
    </div>
</div>
@endsection
