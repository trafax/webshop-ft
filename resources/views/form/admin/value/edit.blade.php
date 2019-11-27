@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form.index') }}">Formulieren</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form.edit', [$formValue->field->form, '#fields']) }}">{{ $formValue->field->form->title }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.form_field.edit', [$formValue->field, '#values']) }}">{{ $formValue->field->title }}</a></li>
                    <li class="breadcrumb-item active">Waarde bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Waarde bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.form_value.update', $formValue) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Titel</label>
                                    <div class="input-group">
                                        <input type="text" name="title" class="form-control" required value="{{ $formValue->title }}">
                                        @include('language.admin.partials.translate', ['field' => 'title', 'parent_id' => $formValue->id])
                                    </div>
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
