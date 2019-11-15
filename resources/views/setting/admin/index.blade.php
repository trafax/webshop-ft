@extends('layouts.admin')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                        <li class="breadcrumb-item active">Instellingen</li>
                    </ol>
                </nav>

                <div class="card">
                    <div class="card-header">Instellingen</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.setting.store') }}">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">Basis</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#webshop" role="tab" aria-controls="nav-profile" aria-selected="false">Webwinkel</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#translations" role="tab" aria-controls="nav-profile" aria-selected="false">Vertalingen</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="nav-profile" aria-selected="false">Google</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="nav-profile" aria-selected="false">SEO</a>
                                </div>
                            </nav>
                            <div class="tab-content pt-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Websitenaam</label>
                                                <input type="text" name="websitename" class="form-control" value="{{ setting('websitename') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Adresgegevens</label>
                                                <input type="text" name="company_address" class="form-control" value="{{ setting('company_address') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="webshop" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Aantal artikelen per pagina</label>
                                                <input type="text" name="products_pp" class="form-control" value="{{ setting('products_pp') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Verstuur bestellingen naar</label>
                                                <input type="text" name="send_orders_to" class="form-control" value="{{ setting('send_orders_to') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Minimale orderafname (0.00)</label>
                                                <p class="small">Wanneer het winkelwagen bedrag onder het opgegeven prijs is kan de klant niet de bestelling plaatsen.</p>
                                                <input type="number" name="minimum_order_taking" class="form-control" value="{{ setting('minimum_order_taking') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="translations" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Activeer inline vertalen</label>
                                                <select class="form-control col-md-4" name="translate">
                                                    <option value="0">Nee</option>
                                                    <option value="1" {{ setting('translate') == 1 ? 'selected' : '' }}>Ja</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Google Analytics code</label>
                                                <input type="text" name="google_analytics" class="form-control" value="{{ setting('google_analytics') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Basis titel</label>
                                                <div class="input-group">
                                                    <input type="text" name="seo_title" class="form-control" value="{{ setting('seo_title') }}">
                                                    @include('language.admin.partials.translate', ['field' => 'seo_title', 'parent_id' => 'settings'])
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Basis zoekwoorden</label>
                                                <div class="input-group">
                                                    <input type="text" name="seo_keywords" class="form-control" value="{{ setting('seo_keywords') }}">
                                                    @include('language.admin.partials.translate', ['field' => 'seo_keywords', 'parent_id' => 'settings'])
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Basis pagina omschrijving</label>
                                                <textarea name="seo_description" class="form-control">{{ setting('seo_description') }}</textarea>
                                                @include('language.admin.partials.translate', ['field' => 'seo_description', 'parent_id' => 'settings'])
                                            </div>
                                        </div>
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
