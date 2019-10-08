@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Talen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>talen</span>
                    <a href="{{ route('admin.language.create') }}">Taal toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Taal</th>
                            <th scope="col" class="border-top-0">Naam</th>
                            <th scope="col" class="border-top-0">Key</th>
                            <th scope="col" class="border-top-0">Standaard</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="sortable" data-action="{{ route('admin.language.sort') }}">
                            @foreach ($languages as $language)
                                <tr id="{{ $language->id }}">
                                    <td><a href="{{ route('admin.language.edit', $language) }}">{{ $language->title }}</a></td>
                                    <td>{{ $language->language }}</td>
                                    <td>{{ $language->language_key }}</td>
                                    <td>{{ $language->is_default == 1 ? 'Ja' : '' }}</td>
                                    <td>
                                        <a href="{{ route('admin.language.destroy', $language) }}" onclick="return confirm('Taal verwijderen?')">verwijder</a>
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
