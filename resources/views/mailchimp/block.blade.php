<div class="container" id="mailchimp">
    <div class="row">
       <div class="col">
           <div class="card">
                <div class="card-header h2">{!! it('mailchimp-title', 'Aanmelden nieuwsbrief') !!}</div>
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {!! session('message') !!}
                        </div>
                    @endif
                    <p>{!! it('mailchimp-body', 'Blijf op de hoogte met onze maandelijke nieuwsbrief.') !!}</p>
                    <hr>
                    <form method="post" action="{{ route('mailchimp.subscribe') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! it('mailchimp-fname', 'Voornaam') !!}</label>
                                    <input type="text" name="fname" class="form-control" required>
                                    @error('fname') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! it('mailchimp-lname', 'Achternaam') !!}</label>
                                    <input type="text" name="lname" class="form-control" required>
                                    @error('lname') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{!! it('mailchimp-email', 'E-mailadres') !!}</label>
                                    <input type="email" name="email" class="form-control" required>
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-green">{!! it('mailchimp-btn', 'Inschrijven') !!}</button>
                        </div>
                    </form>
               </div>
           </div>
       </div>
    </div>
    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
        </div>
    @endif
</div>
