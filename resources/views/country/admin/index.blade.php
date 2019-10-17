@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Landen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Landen</span>
                    <a href="{{ route('admin.country.create') }}">Land toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Land naam</th>
                            <th scope="col" class="border-top-0">Korte naam</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                                <tr>
                                    <td><a href="{{ route('admin.country.edit', $country) }}">{{ $country->title }}</a></td>
                                    <td>{{ $country->language_key }}</td>
                                    <td>
                                        <a href="{{ route('admin.country.destroy', $country) }}" onclick="return confirm('Land verwijderen?')">verwijder</a>
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
