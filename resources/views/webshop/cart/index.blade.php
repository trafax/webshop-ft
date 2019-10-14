
@extends('layouts.website')

@section('content')
    <div class="container">
        <h1 class="mt-4">Winkelwagen</h1>

        <nav>
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webshop') }}">Webshop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Winkelwagen</li>
            </ol>
        </nav>

        <hr>

        <table class="table table-borderless shopping-cart">
            <thead class="bg-light">
                <tr>
                    <th>Artikel</th>
                    <th>Aantal</th>
                    <th>Prijs</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="product border-bottom">
                        <td valign="top align-middle">
                            <div class="d-flex">
                                <div class="image mr-3" style="background-image: url('/storage/{{ $item->id->assets()->get()->first()->file }}')"></div>
                                <span class="name mt-3">{{ t($item->id, 'title') }}</span>
                            </div>
                        </td>
                        <td class="align-middle">{{ $item->qty }}</td>
                        <td class="align-middle">&euro; {{ price($item->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
