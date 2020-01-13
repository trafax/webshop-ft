@extends('layouts.admin')

@section('content')
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
                            {{-- @php $statics = \App\Models\Order::statics(date('Y')-1); @endphp --}}
                            <div class="card-header"><strong>25</strong> meeste bestelde producten</div>
                            <div class="card-body">
                                @foreach (\App\Models\Order::most_ordered(25) as $rule)
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
