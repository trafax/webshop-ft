<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col" class="border-top-0">Klantnaam</th>
            <th scope="col" class="border-top-0">E-mailadres</th>
            <th scope="col" class="border-top-0">Aantal bestellingen</th>
            <th scope="col" class="border-top-0">Totaal betaald <small>(zonder verzendkosten)</small></th>
            <th scope="col" class="border-top-0 text-right">Acties</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->firstname }} {{ $customer->preposition }} {{ $customer->lastname }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->orders->count() }}</td>
                @php
                $total = $customer->orders->sum(function($order){
                    if (@$order->order->status == 'paid') {
                        return $order->rules->sum('price');
                    }
                });
                @endphp
                <td>&euro; {{ price($total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
