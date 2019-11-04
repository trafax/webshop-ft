@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.shipping.index') }}">Verzendkosten</a></li>
                    <li class="breadcrumb-item active">Verzendkosten bewerken</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Verzendkosten bewerken</span>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.shipping.update', $shipping) }}">
                        @method('PUT')
                        @csrf
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#rules" role="tab" aria-controls="nav-profile" aria-selected="false">Regels</a>
                            </div>
                        </nav>
                        <div class="tab-content pt-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Titel</label>
                                            <input type="text" name="title" class="form-control" value="{{ $shipping->title }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="rules" role="tabpanel" aria-labelledby="nav-profile-tab">

                                <button class="btn btn-primary add-rule" type="button">Regel toevoegen</button>

                                <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.add-rule').on('click', function(){
                                        $.ajax({
                                            url: '{{ route('admin.rule.create') }}',
                                            type: "get",
                                            data: { shipping: '{{ $shipping->id }}' },
                                            success: function(data) {
                                                $('body').append(data);
                                                $('.modal').modal('show');
                                                $('.modal').on('hidden.bs.modal', function (e) {
                                                    $('.modal').remove();
                                                });
                                            }
                                        });
                                    });
                                });
                                </script>

                                <ul class="list-group list-group-flush mt-4">
                                    @foreach ($shipping->rules as $rule)

                                        <script type="text/javascript">
                                        $(document).ready(function(){
                                            $('.edit-rule-{{ $rule->id }}').on('click', function(){
                                                $.ajax({
                                                    url: '{{ route('admin.rule.edit', $rule->id) }}',
                                                    type: "get",
                                                    data: { shipping: '{{ $shipping->id }}' },
                                                    success: function(data) {
                                                        $('body').append(data);
                                                        $('.modal').modal('show');
                                                        $('.modal').on('hidden.bs.modal', function (e) {
                                                            $('.modal').remove();
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                        </script>

                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col"><a href="javascript:;" class="edit-rule-{{ $rule->id }}">{{ $rule->country->title }}</a></div>
                                                <div class="col">€ {{ price($rule->price) }}</div>
                                                <div class="col text-right"><a href="{{ route('admin.rule.destroy', $rule) }}" onclick="return confirm('Regel verwijderen?')"><i class="fas fa-times"></i></a></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
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
