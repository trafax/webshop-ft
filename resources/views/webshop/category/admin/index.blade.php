@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Categorieën</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Categorieën</span>
                    <a href="{{ route('admin.category.create') }}">Categorie toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Categorienaam</th>
                            <th scope="col" class="border-top-0">Link</th>
                            <th scope="col" class="border-top-0">Producten</th>
                            <th scope="col" class="border-top-0">Seizoen</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="sortable" data-action="{{ route('admin.category.sort') }}">
                            @php
                                $tree = function ($categories, $prefix = '') use (&$tree)
                                {
                                    foreach ($categories as $category)
                                    {
                                        echo '
                                        <tr id="'.$category->id.'">
                                            <td><a href="'. route('admin.category.edit', $category) .'">'. ( $category->visible == 0 ? '<i class="fas fa-eye-slash"></i>' : '') . $prefix . ' ' . $category->title .'</a></td>
                                            <td class="small">category/'. $category->slug .'</td>
                                            <td>'. $category->products()->count() .'</td>
                                            <td>'. ($category->season == 1 ? 'Zomer' : 'Voorjaar') .'</td>
                                            <td>
                                                <a href="'. route('admin.category.destroy', $category) .'" onclick="return confirm(\'Categorie verwijderen?\')">verwijder</a>
                                            </td>
                                        </tr>';

                                        $tree($category->children, $prefix.'-');
                                    }
                                };

                                echo $tree($categories);
                            @endphp
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
