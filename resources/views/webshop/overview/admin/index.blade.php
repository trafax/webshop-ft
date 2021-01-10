@extends('layouts.admin')

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Overzicht</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Overzicht</span>
                </div>
                <div class="card-body">
                    <div class="card-group mb-3">

                        <div class="card">
                            @php
                                $year = date('Y') - 1;
                                $months = ['jan','feb','mar','apr','mei','jun','jul','aug','sep','okt','nov','dec'];
                            @endphp
                            <div class="card-header">Overzicht {{ $year }}</div>
                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['corechart']});

                                google.charts.setOnLoadCallback(drawInkomsten_1);

                                function drawInkomsten_1() {
                                    var data = google.visualization.arrayToDataTable([
                                        ["Maand", ""],
                                        @foreach ($months as $key => $month)
                                            ['{{ $months[$key] }}',
                                                {{ App\Models\Order::where('status', 'paid')->whereRaw('month(created_at) = ?', ($key+1))->whereRaw('year(created_at) = ?', $year)->get()->sum('total') }},
                                            ],
                                        @endforeach
                                    ]);

                                    var options = {
                                    title : 'Inkomsten',
                                    vAxis: {title: 'Bedrag'},
                                    hAxis: {title: 'Maanden'},
                                    seriesType: 'bars',
                                    series: {5: {type: 'line'}}        };

                                    var chart = new google.visualization.ComboChart(document.getElementById('inkomsten_prev'));
                                    chart.draw(data, options);
                                }
                            </script>

                            <div id="inkomsten_prev" style="width: 100%;"></div>

                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['corechart']});

                                google.charts.setOnLoadCallback(drawTotalOrders_1);

                                function drawTotalOrders_1() {
                                    var data = google.visualization.arrayToDataTable([
                                        ["Maand", ""],
                                        @foreach ($months as $key => $month)
                                            ['{{ $months[$key] }}',
                                                {{ App\Models\Order::where('status', 'paid')->whereRaw('month(created_at) = ?', ($key+1))->whereRaw('year(created_at) = ?', $year)->get()->count() }},
                                            ],
                                        @endforeach
                                    ]);

                                    var options = {
                                    title : 'Aantal bestellingen',
                                    vAxis: {title: 'Aantal'},
                                    hAxis: {title: 'Maanden'},
                                    seriesType: 'bars',
                                    series: {5: {type: 'line'}}        };

                                    var chart = new google.visualization.ComboChart(document.getElementById('orderTotal_prev'));
                                    chart.draw(data, options);
                                }
                            </script>
                            <div id="orderTotal_prev" style="width: 100%;"></div>
                        </div>

                        <div class="card">
                            @php
                                $year = date('Y');
                                $months = ['jan','feb','mar','apr','mei','jun','jul','aug','sep','okt','nov','dec'];
                            @endphp
                            <div class="card-header">Overzicht {{ $year }}</div>

                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['corechart']});

                                google.charts.setOnLoadCallback(drawInkomsten_2);

                                function drawInkomsten_2() {
                                    var data = google.visualization.arrayToDataTable([
                                        ["Maand", ""],
                                        @foreach ($months as $key => $month)
                                            ['{{ $months[$key] }}',
                                                {{ App\Models\Order::where('status', 'paid')->whereRaw('month(created_at) = ?', ($key+1))->whereRaw('year(created_at) = ?', $year)->get()->sum('total') }},
                                            ],
                                        @endforeach
                                    ]);

                                    var options = {
                                    title : 'Inkomsten',
                                    vAxis: {title: 'Bedrag'},
                                    hAxis: {title: 'Maanden'},
                                    seriesType: 'bars',
                                    series: {5: {type: 'line'}}        };

                                    var chart = new google.visualization.ComboChart(document.getElementById('inkomsten_current'));
                                    chart.draw(data, options);
                                }
                            </script>
                            <div id="inkomsten_current" style="width: 100%;"></div>

                            <script type="text/javascript">
                                google.charts.load('current', {'packages':['corechart']});

                                google.charts.setOnLoadCallback(drawTotalOrders_2);

                                function drawTotalOrders_2() {
                                    var data = google.visualization.arrayToDataTable([
                                        ["Maand", ""],
                                        @foreach ($months as $key => $month)
                                            ['{{ $months[$key] }}',
                                                {{ App\Models\Order::where('status', 'paid')->whereRaw('month(created_at) = ?', ($key+1))->whereRaw('year(created_at) = ?', $year)->get()->count() }},
                                            ],
                                        @endforeach
                                    ]);

                                    var options = {
                                    title : 'Aantal bestellingen',
                                    vAxis: {title: 'Aantal'},
                                    hAxis: {title: 'Maanden'},
                                    seriesType: 'bars',
                                    series: {5: {type: 'line'}}        };

                                    var chart = new google.visualization.ComboChart(document.getElementById('orderTotal_current'));
                                    chart.draw(data, options);
                                }
                            </script>
                            <div id="orderTotal_current" style="width: 100%;"></div>

                        </div>

                    </div>

                    <div class="card-group">

                        <div class="card">
                            @php $statics = \App\Models\Order::statics(date('Y')-1); @endphp
                            <div class="card-header">Overzicht <strong>{{ $statics['year'] }}</strong></div>
                            <div class="card-body">
                                {{ $statics['total'] }} bestelling(en) succesvol geplaatst.<br>
                                Totaal is er voor <strong>&euro; {{ price($statics['total_amount']) }}</strong> besteld.<br>
                                De totaal betaalde BTW is <strong>&euro; {{ price(($statics['total_amount'] / 100) * 9) }}</strong><br>
                                Er is voor <strong>&euro; {{ price($statics['total_shipping']) }}</strong> aan verzendkosten betaald.
                            </div>
                        </div>

                        <div class="card">
                            @php $statics = \App\Models\Order::statics(date('Y')); @endphp
                            <div class="card-header">Overzicht <strong>{{ $statics['year'] }}</strong></div>
                            <div class="card-body">
                                {{ $statics['total'] }} bestelling(en) succesvol geplaatst.<br>
                                Totaal is er voor <strong>&euro; {{ price($statics['total_amount']) }}</strong> besteld.<br>
                                De totaal betaalde BTW is <strong>&euro; {{ price(($statics['total_amount'] / 100) * 9) }}</strong><br>
                                Er is voor <strong>&euro; {{ price($statics['total_shipping']) }}</strong> aan verzendkosten betaald.
                            </div>
                        </div>

                    </div>

                    <div class="card-group mt-3">

                        <div class="card">
                            <div class="card-header"><strong>25</strong> meeste bestelde producten <strong>{{ date('Y') - 1 }}</strong></div>
                            <div class="card-body">
                                @foreach (\App\Models\Order::most_ordered(25, (int) (date('Y')-1)) as $rule)
                                    @if (is_array($rule->options))
                                        @php $hoeveelheid = ''; @endphp
                                        @foreach ($rule->options as $option => $value)
                                            {{-- @php $variation = \App\Models\Variation::find($option) @endphp --}}
                                            @php $hoeveelheid .= $value . ''; @endphp
                                        @endforeach
                                    @endif
                                    {{ $rule->total }}x {{ $rule->product->title }} <small>({!! $hoeveelheid !!})</small><br>
                                @endforeach
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><strong>25</strong> meeste bestelde producten <strong>{{ date('Y') }}</strong></div>
                            <div class="card-body">
                                @foreach (\App\Models\Order::most_ordered(25, (int) date('Y')) as $rule)
                                    @if (is_array($rule->options))
                                        @php $hoeveelheid = ''; @endphp
                                        @foreach ($rule->options as $option => $value)
                                            {{-- @php $variation = \App\Models\Variation::find($option) @endphp --}}
                                            @php $hoeveelheid .= $value . ''; @endphp
                                        @endforeach
                                    @endif
                                    {{ $rule->total }}x {{ $rule->product->title }} <small>({!! $hoeveelheid !!})</small><br>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
