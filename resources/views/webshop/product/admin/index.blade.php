@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Producten</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Producten</span>
                    <a href="{{ route('product.create') }}">Product toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Productnaam</th>
                            <th scope="col" class="border-top-0">Link</th>
                            <th scope="col" class="border-top-0">Prijs</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td><a href="{{ route('product.edit', $product) }}">{{ $product->title }}</a></td>
                                    <td class="small">product/{{ $product->slug }}</td>
                                    <td>&euro; {{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('product.destroy', $product) }}" onclick="return confirm('Product verwijderen?')">verwijder</a>
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