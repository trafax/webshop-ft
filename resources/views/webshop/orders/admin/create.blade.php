@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Bestellingen</a></li>
                    <li class="breadcrumb-item active">Bestelling plaatsen</li>
                </ol>
            </nav>

            <div class="card mb-4">
                <div class="card-header">
                    Bestelling plaatsen
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.order.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Klant</label>
                                    <select class="form-control" name="id_user" required>
                                        <option value="">Selecteer een klant</option>
                                        @foreach (\App\Models\User::where('role', 'customer')->get() as $user)
                                            <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->preposition }} {{ $user->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
