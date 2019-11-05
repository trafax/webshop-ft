@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Verzendkosten</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Producten</span>
                    {{-- <a href="{{ route('admin.shipping.create') }}">Verzendkosten toevoegen</a> --}}
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Titel</th>
                            {{-- <th scope="col" class="border-top-0">Acties</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippings as $shipping)
                                <tr>
                                    <td><a href="{{ route('admin.shipping.edit', $shipping) }}">{{ $shipping->title }}</a></td>
                                    <td>
                                        {{-- <a href="{{ route('admin.shipping.destroy', $shipping) }}" onclick="return confirm('Verzendkosten verwijderen?')">verwijder</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
