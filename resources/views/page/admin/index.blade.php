@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Pagina's</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex">
                    Pagina's
                    <a href="{{ route('admin.page.create') }}" class="ml-auto">Pagina toevoegen</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Titel</th>
                            <th scope="col" class="border-top-0">Link</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="sortable" data-action="{{ route('admin.page.sort') }}">
                            @foreach ($pages as $page)
                                <tr id="{{ $page->id }}">
                                    <td><a href="{{ route('admin.page.edit', $page) }}">{{ $page->title }}</a></td>
                                    <td class="small">{{ $page->slug }}</td>
                                    <td>
                                        <a href="{{ route('admin.page.destroy', $page) }}" onclick="return confirm('Pagina verwijderen?')">verwijder</a>
                                    </td>
                                </tr>
                                @foreach ($page->children as $child)
                                    <tr id="{{ $child->id }}">
                                        <td><a href="{{ route('admin.page.edit', $child) }}">- {{ $child->title }}</a></td>
                                        <td class="small">{{ $child->slug }}</td>
                                        <td>
                                            <a href="{{ route('admin.page.destroy', $child) }}" onclick="return confirm('Pagina verwijderen?')">verwijder</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
