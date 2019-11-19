@if (Auth::user() && Auth::user()->role == 'admin')
    <script>
        $(function(){
            $('[data-create-block]').on('click', function(){
                $.ajax({
                    url: '{{ route('admin.block.create') }}',
                    data: {parent_id: '{{ $parent_id }}'},
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
            });
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text-center border border-secondary my-4">
                    <a href="#" data-create-block="true" class="stretched-link d-block py-4 h1 m-0 text-secondary text-decoration-none">+</a>
                </div>
            </div>
        </div>
    </div>
@endif
