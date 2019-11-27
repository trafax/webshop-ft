@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form.index') }}">Formulieren</a></li>
                    <li class="breadcrumb-item active">Formulier bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Formulier bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.form.update', $form) }}">
                        @csrf
                        @method('PUT')
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#fields" role="tab" aria-controls="nav-home" aria-selected="true">Velden</a>
                                <a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#text" role="tab" aria-controls="nav-home" aria-selected="true">Teksten</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Titel</label>
                                            <div class="input-group">
                                                <input type="text" name="title" class="form-control" required value="{{ $form->title }}">
                                                @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $form->id])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Verstuur formulier naar</label>
                                            <input type="email" name="send_to_email" class="form-control" required value="{{ $form->send_to_email }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="fields" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card">

                                    <script type="text/javascript">
                                        function create_field()
                                        {
                                            $.ajax({
                                                url: '{{ route('admin.form_field.create') }}',
                                                data: {parent_id: '{{ $form->id }}'},
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
                                        Velden
                                        <a href="javascript:;" onclick="return create_field()" class="ml-auto">Veld toevoegen</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="border-top-0">Titel</th>
                                                    <th scope="col" class="border-top-0">Type</th>
                                                    <th scope="col" class="border-top-0"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="sortable" data-action="{{ route('admin.form_field.sort') }}">
                                                @foreach ($form->fields as $field)
                                                    <tr id="{{ $field->id }}">
                                                        <td><a href="{{ route('admin.form_field.edit', $field) }}">{{ $field->title }} {{ $field->required == 1 ? '*' : '' }}</a></td>
                                                        <td>{{ $field->type }}</td>
                                                        <td class="text-right">
                                                            <a href="{{ route('admin.form_field.destroy', $field->id) }}" onclick="return confirm('Veld verwijderen?')">verwijder</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="form-group">
                                    <label>Tekst website</label>
                                    <textarea name="text_website" class="editor">{!! $form->text_website !!}</textarea>
                                    @include('language.admin.partials.translate', ['field' => 'text_website', 'parent_id' => $form->id, 'editor' => true])
                                </div>
                                <div class="form-group">
                                    <label>Tekst e-mail</label>
                                    <textarea name="text_email" class="editor">{!! $form->text_email !!}</textarea>
                                    @include('language.admin.partials.translate', ['field' => 'text_email', 'parent_id' => $form->id, 'editor' => true])
                                </div>
                            </div>
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
