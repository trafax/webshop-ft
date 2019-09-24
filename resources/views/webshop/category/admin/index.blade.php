@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Categorieën</span>
                    <a href="{{ route('category.create') }}">Categorie toevoegen</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="border-top-0">Categorienaam</th>
                            <th scope="col" class="border-top-0">Link</th>
                            <th scope="col" class="border-top-0">Producten</th>
                            <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="sortable" data-action="{{ route('category.sort') }}">
                            @php
                                $tree = function ($categories, $prefix = '') use (&$tree)
                                {
                                    foreach ($categories as $category)
                                    {
                                        echo '
                                        <tr id="'.$category->id.'">
                                            <td><a href="'. route('category.edit', $category) .'">'. $prefix . ' ' . $category->title .'</a></td>
                                            <td class="small">category/'. $category->slug .'</td>
                                            <td>0</td>
                                            <td>
                                                <a href="'. route('category.destroy', $category) .'" onclick="return confirm(\'Categorie verwijderen?\')">verwijder</a>
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
