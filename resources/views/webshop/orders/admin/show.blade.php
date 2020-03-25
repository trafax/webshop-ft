@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Bestellingen</a></li>
                    <li class="breadcrumb-item active">Bestelling {{ $order->nr }}</li>
                </ol>
            </nav>

            <form method="post" action="{{ route('admin.order.update', $order) }}">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header">
                        Status bestelling
                    </div>
                    <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Status bestelling</label>
                                        <select name="order_status" class="form-control">
                                            <option value="">Selecteer een status</option>
                                            <option value="Is betaald" {{ $order->order_status == 'Is betaald' ? 'selected' : '' }}>Is betaald</option>
                                            <option value="In behandeling" {{ $order->order_status == 'In behandeling' ? 'selected' : '' }}>In behandeling</option>
                                            <option value="Verzonden en voltooid" {{ $order->order_status == 'Verzonden en voltooid' ? 'selected' : '' }}>Verzonden en voltooid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Betaalstatus</label>
                                        <select name="status" class="form-control">
                                            <option value="">Selecteer de bestaalstatus</option>
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Nog niet betaald</option>
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Betaald</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <script type="text/javascript">
                window.add_invoice_rule = function() {
                    $.ajax({
                        url: '/admin/order/add_invoice_rule',
                        type: "get",
                        data: {'order_id' : '{{ $order->id }}'},
                        success: function(data) {
                            $('body').append(data);
                            $('.modal').modal('show');
                            $('.modal').on('hidden.bs.modal', function (e) {
                                $('.modal').remove();
                            });
                        }
                    });
                };
                </script>

                <a href="javascript:;" class="btn btn-info mb-2" onclick="return window.add_invoice_rule()">Factuurregel toevoegen</a>

                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span>Bestelling {{ $order->nr }}</span>
                    </div>
                    <div class="card-body">

                        <table width="700" style="width: 100% !important; margin-top: 10px;">
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
                                            <td>{{ $order->customer->firstname }} {{ $order->customer->preposition }} {{ $order->customer->lastname }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $order->customer->street }} {{ $order->customer->number }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $order->customer->zipcode }} {{ $order->customer->city }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ get_country_by_key($order->customer->language_key) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $order->customer->email }}</td>
                                        </tr>
                                    </table>
                                    @if ($order->customer->other_delivery == 1)
                                        <h2>Afleveradres</h2>
                                        <table cellspacing="0" style="width: 100% !important; text-align: right;">
                                            <tr>
                                                <td>{{ $order->customer->delivery_street }} {{ $order->customer->delivery_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ $order->customer->delivery_zipcode }} {{ $order->customer->delivery_city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ get_country_by_key($order->customer->delivery_language_key) }}</td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            </tr>
                            @if ($order->comment)
                                <tr>
                                    <td valign="top" colspan="2" style="width: 100% !important;">
                                        <h4 style="margin-top: 10px; margin-bottom: 0;">Opmerkingen</h4>
                                        <p style="color: red; margin: 0; padding: 0;">{{ strip_tags(nl2br($order->comment)) }}</p>
                                    </td>
                                </tr>
                            @endif
                        </table>

                        <div style="border-top: #CCC solid 1px; width: 100%; margin: 20px 0px; width: 100%;"></div>

                        <table width="700" cellpadding="5" style="width: 100% !important;">

                            @foreach ($order->rules as $rule)
                                <tr>
                                    <td>
                                        <input type="hidden" name="rule[{{ $rule->id }}][product_id]" value="{{ $rule->product_id }}">
                                        <strong>{{ $rule->sku }} : {{ $rule->title }}</strong>
                                        @if (is_array($rule->options))
                                            @foreach ($rule->options as $option => $value)
                                            @php $option = App\Models\ProductVariation::where('slug', $option)->first() @endphp
                                            @php $variation = \App\Models\Variation::find($option->variation_id) @endphp
                                                <br><small>{{ t($variation, 'title') }}: {{ $value }}</small>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @foreach (\App\Models\Variation::where('selectable', 1)->orderBy('sort')->get() as $key => $variation)
                                            @php $rows = $rule->product->variations->where('title', $variation->title); @endphp
                                            @if ($rows->count() > 0)
                                                <select class="form-control" name="rule[{{ $rule->id }}][options][{{ $variation->id }}]">
                                                @foreach ($rows as $row)
                                                    @php
                                                        $price = '';
                                                        if ($row->pivot->fixed_price > 0)
                                                        {
                                                            $price = '(&euro; '.price($row->pivot->fixed_price).')';
                                                        }
                                                        else if ($row->pivot->adding_price > 0)
                                                        {
                                                            $price = '+ (&euro; '.$row->pivot->adding_price.')';
                                                        }
                                                    @endphp
                                                    <option {{ @in_array($row->pivot->slug, $rule->options) ? 'selected' : '' }} value="{{ $row->pivot->slug }}">{{ $row->pivot->title }} {!! $price !!}</option>
                                                @endforeach
                                                </select>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td><input type="number" name="rule[{{ $rule->id }}][qty]" value="{{ $rule->qty }}" class="form-control col-3"></td>
                                    <td align="right">&euro; {{ price($rule->price) }}</td>
                                    <td class="text-right"><a href="{{ route('admin.order.delete_row', $rule) }}">x</a></td>
                                </tr>
                                <tr><td colspan="5"><div style="border-bottom: #CCC solid 1px;"></div></td></tr>
                            @endforeach

                            <tr><td colspan="4"><div style="margin-top: 10px;"></div></td></tr>

                            <tr>
                                <td colspan="4" align="right"><strong>Sub-totaal</strong></td>
                                <td align="right">&euro; {{ price($order->sub_total) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right"><strong>Verzendkosten</strong></td>
                                <td align="right">&euro; {{ price($order->shipping) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right"><strong>BTW (9%)</strong></td>
                                <td align="right">&euro; {{ price($order->tax) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right"><strong>Totaal</strong></td>
                                <td align="right">&euro; {{ price($order->total) }}</td>
                            </tr>

                        </table>

                    </div>
                </div>

                <hr>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary ml-auto">Opslaan</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
