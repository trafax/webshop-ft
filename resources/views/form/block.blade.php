<div class="container">

    <div class="row">

        @if (@$block->block_data['text'] == 'left')
            @include('form.text')
        @endif

        <div class="{{ @$block->block_data['text'] ? 'col-md-6' : 'col' }}">

            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {!! session('message') !!}
                </div>
            @endif

            <form method="post" action="{{ route('form.send', $form) }}">
                @csrf
                @foreach ($form->fields as $field)
                    @switch($field->type)
                        @case('text')
                            @include('form.fields.text')
                            @break
                        @case('textarea')
                            @include('form.fields.textarea')
                            @break
                        @case('dropdown')
                            @include('form.fields.dropdown')
                            @break
                        @case('checkbox')
                            @include('form.fields.checkbox')
                            @break
                        @case('radio')
                            @include('form.fields.radio')
                            @break
                        @case('email')
                            @include('form.fields.email')
                            @break
                    @endswitch
                @endforeach

                <script src="https://www.google.com/recaptcha/api.js?render=6LdkcuEUAAAAACIERIxSlg7g4WaJtKDL15m9QzhJ"></script>
                <script>
                    function setToken()
                    {
                        grecaptcha.ready(function() {
                            grecaptcha.execute('6LdkcuEUAAAAACIERIxSlg7g4WaJtKDL15m9QzhJ', {action: 'homepage'}).then(function(token) {
                                $('[name=g_token]').val(token);
                            });
                        });
                    }

                    setToken();
                </script>
                <input type="hidden" name="g_token" value="">
                <button type="submit" name="submit" onclick="return setToken()" class="btn btn-green">{!! it('form-submit-'. $form->id, 'Verzend') !!}</button>
            </form>
        </div>

        @if (@$block->block_data['text'] == 'right')
            @include('form.text')
        @endif

    </div>

    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="block-actions">
            @php $uniq_id = uniqid('_1') @endphp
            <a href="javascript:;" onclick="return edit_block_{{ $uniq_id }}()"><i class="far fa-edit"></i></a>
            <a href="javascript:;" class="handle"><i class="fas fa-expand-arrows-alt"></i></a>
            <a href="{{ route('admin.block.destroy', $block) }}" onclick="return delete_block_{{ $uniq_id }}()"><i class="far fa-trash-alt"></i></a>
            <script type="text/javascript">
                function edit_block_{{ $uniq_id }}() {
                    $.ajax({
                        url: '{{ route('admin.form.block.edit', $block) }}',
                        data: '',
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
                }
                function delete_block_{{ $uniq_id }}() {
                    if (! confirm('Blok verwijderen?')) {
                        return false;
                    }
                }
            </script>
        </div>
    @endif
</div>
