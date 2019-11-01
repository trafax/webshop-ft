@extends('layouts.email')

@section('content')
    <table  style="width: 700px !important; margin-top: 10px;">
        <tr>
            <td valign="top" style="width: 50%  !important;">
                <h2>Factuurgegevens</h2>
                <table cellspacing="0" style="width: 100% !important;">
                    <tr>
                        <td>Factuurnummer:</td>
                        <td>{{ $order->nr }}</td>
                    </tr>
                    <tr>
                        <td>Factuurdatum:</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Betaalmethode:</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                </table>
            </td>
            <td valign="top" style="width: 50%  !important; text-align: right">
                <h2>Factuuradres</h2>
                <table cellspacing="0" style="width: 100% !important; text-align: right;">
                    <tr>
                        <td>{{ $order->customer->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $order->customer->street }} {{ $order->customer->number }}</td>
                    </tr>
                    <tr>
                        <td>{{ $order->customer->zipcode }} {{ $order->customer->city }}</td>
                    </tr>
                    <tr>
                        <td>{{ $order->customer->country }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="border-top: #CCC solid 1px; width: 100%; margin: 20px 0px; width: 700px;"></div>

    <table width="700" cellpadding="5" style="width: 700px !important;">

        @foreach ($order->rules as $rule)
            <tr>
                <td>
                    <strong>{{ $rule->sku }} : {{ $rule->title }}</strong>
                    @foreach ($rule->options as $option => $value)
                        <br><small>{{ $option }}: {{ $value }}</small>
                    @endforeach
                </td>
                <td>{{ $rule->qty }}x</td>
                <td align="right">&euro; {{ price($rule->price) }}</td>
            </tr>
            <tr><td colspan="3"><div style="border-bottom: #CCC solid 1px;"></div></td></tr>
        @endforeach

        <tr><td colspan="3"><div style="margin-top: 10px;"></div></td></tr>

        <tr>
            <td colspan="2" align="right"><strong>Sub-totaal</strong></td>
            <td align="right">&euro; {{ price($order->sub_total) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Verzendkosten</strong></td>
            <td align="right">&euro; {{ price($order->shipping) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>BTW (9%)</strong></td>
            <td align="right">&euro; {{ price($order->tax) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Totaal</strong></td>
            <td align="right">&euro; {{ price($order->total) }}</td>
        </tr>

    </table>
@endsection