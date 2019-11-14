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
