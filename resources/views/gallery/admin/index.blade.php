@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Fotoalbumbs</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex">
                    Formulieren
                    <a href="{{ route('admin.gallery.create') }}" class="ml-auto">Fotoalbum toevoegen</a>
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
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $gallery)
                                <tr>
                                    <td><a href="{{ route('admin.gallery.edit', $gallery) }}">{{ $gallery->title }}</a></td>
                                    <td>
                                        <a href="{{ route('admin.gallery.destroy', $gallery) }}" onclick="return confirm('Fotoalbum verwijderen?')">verwijder</a>
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
