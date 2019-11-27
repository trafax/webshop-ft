@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form.index') }}">Formulieren</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form.edit', [$formField->form, '#fields']) }}">{{ $formField->form->title }}</a></li>
                    <li class="breadcrumb-item active">Veld bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Veld bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.form_field.update', $formField) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Veld</a>
                                @if ($formField->hasValues())
                                    <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#values" role="tab" aria-controls="nav-home" aria-selected="true">Waarden</a>
                                @endif
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Titel</label>
                                            <div class="input-group">
                                                <input type="text" name="title" class="form-control" required value="{{ $formField->title }}">
                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $formField->id])
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="d-block">Type</label>
                                                    {{ $formField->type }}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Verplicht</label>
                                                    <select name="required" class="form-control">
                                                        <option value="0">Nee</option>
                                                        <option value="1" {{ $formField->required == 1 ? 'selected' : '' }}>Ja</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($formField->hasValues())
                                <div class="tab-pane fade" id="values" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="card">

                                        <script type="text/javascript">
                                            function create_value()
                                            {
                                                $.ajax({
                                                    url: '{{ route('admin.form_value.create') }}',
                                                    data: {parent_id: '{{ $formField->id }}'},
                                                    method: 'get',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    success: function(response) {
                                                        $('body').prepend(response);
                                                        $('.modal').modal('show');

                                                        $('.modal').on('hidden.bs.modal', function (e) {
                                                            $('.modal').remove();
                                                        });
                                                    }
                                                });

                                                return false;
                                            }
                                        </script>

                                        <div class="card-header d-flex">
                                            Waarden
                                            <a href="javascript:;" onclick="return create_value()" class="ml-auto">Waarde toevoegen</a>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="border-top-0">Titel</th>
                                                        <th scope="col" class="border-top-0"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="sortable" data-action="{{ route('admin.form_value.sort') }}">
                                                    @foreach ($formField->values as $value)
                                                        <tr id="{{ $value->id }}">
                                                            <td><a href="{{ route('admin.form_value.edit', $value) }}">{{ $value->title }}</a></td>
                                                            <td class="text-right">
                                                                <a href="{{ route('admin.form_value.destroy', $value->id) }}" onclick="return confirm('Waarde verwijderen?')">verwijder</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
