@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.emailTemplate.index') }}">E-mail templates</a></li>
                    <li class="breadcrumb-item active">E-mail template aanpassen</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>E-mail template aanpassen</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.emailTemplate.update', $emailTemplate) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Titel</label>
                            <input type="text" name="title" value="{{ $emailTemplate->title }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tekst</label>
                            <textarea name="content" class="editor form-control" rows="20">{{ $emailTemplate->content }}</textarea>
                            @include('language.admin.partials.translate', ['field' => 'content', 'parent_id' => $emailTemplate->id, 'editor' => true])
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
