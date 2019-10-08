@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Variaties</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Variaties</span>
                    <a href="{{ route('admin.variation.create') }}">Variatie toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Variatienaam</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="sortable" data-action="{{ route('admin.variation.sort') }}">
                            @foreach ($variations as $variation)
                                <tr id={{ $variation->id }}>
                                    <td><a href="{{ route('admin.variation.edit', $variation) }}">{{ $variation->title }}</a></td>
                                    <td>
                                        <a href="{{ route('admin.variation.destroy', $variation) }}" onclick="return confirm('Variatie verwijderen?')">verwijder</a>
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
