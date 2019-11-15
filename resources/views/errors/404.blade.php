@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row">
        <div class="col mt-4 text-center">
            <h1 class="mt-4">{!! it('404-title', 'Helaas, pagina niet gevonden.') !!}</h1>
            {!! it('404-description', 'De gevraagde pagina kon niet worden gevonden.', true) !!}
        </div>
    </div>
</div>
@endsection
