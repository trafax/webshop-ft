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

            <div class="card mb-4">
                <div class="card-header">
                    Status bestelling
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.order.update', $order) }}">
                        @csrf
                        @method('PUT')
                        <select name="order_status" class="form-control col-3">
                            <option value="">Selecteer een status</option>
                            <option value="Is betaald" {{ $order->order_status == 'Is betaald' ? 'selected' : '' }}>Is betaald</option>
                            <option value="In behandeling" {{ $order->order_status == 'In behandeling' ? 'selected' : '' }}>In behandeling</option>
                            <option value="Verzonden en voltooid" {{ $order->order_status == 'Verzonden en voltooid' ? 'selected' : '' }}>Verzonden en voltooid</option>
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Opslaan</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Bestelling {{ $order->nr }}</span>
                </div>
                <div class="card-body">
                    @include('webshop.emails.partials.order_details')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
