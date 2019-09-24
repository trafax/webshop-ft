@extends('layouts.admin')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Instellingen</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('setting.store') }}">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Google</a>
                                </div>
                            </nav>
                            <div class="tab-content pt-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="form-group">
                                        <label for="websitename">Websitenaam</label>
                                        <input type="text" name="websitename" id="websitename" class="form-control" value="{{ setting('websitename') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">Adresgegevens</label>
                                        <input type="text" name="company_address" id="company_address" class="form-control" value="{{ setting('company_address') }}">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="form-group">
                                        <label for="google_analytics">Google Analytics code</label>
                                        <input type="text" name="google_analytics" id="google_analytics" class="form-control" value="{{ setting('google_analytics') }}">
                                    </div>
                                </div>
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
