@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Producten</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="row w-75">
                        <div class="col-6">
                            <form method="post" action="{{ route('admin.product.search') }}">
                                @csrf
                                <input type="text" name="search" placeholder="Zoek producten" class="form-control">
                            </form>
                        </div>
                        <div class="col-6">
                            <script type="text/javascript">
                            $(function(){
                                $('.with-selected').on('change', function(){
                                    var action = $('.with-selected').val();
                                    var ids = $(".check:checked").map(function(){
                                        if ($(this).val()) {
                                            return $(this).val();
                                        }
                                    }).get();

                                    if (confirm('Geselecteerde actie uitvoeren?'))
                                    {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            data: {'ids' : ids},
                                            url: action,
                                            type: 'POST',
                                            success: function(response)
                                            {
                                                if (response) {
                                                    window.location.reload();
                                                }
                                            },
                                            dataType: 'json'
                                        });
                                    }
                                });
                            });
                            </script>
                            <div class="d-flex w-100">
                                <select class="form-control with-selected">
                                    <option value="">Met geselecteerde</option>
                                    <option value="{{ route('admin.product.delete_selected') }}">Verwijder geselecteerde</option>
                                    <option value="{{ route('admin.product.set_view_mode', 0) }}">Maak niet zichtbaar</option>
                                    <option value="{{ route('admin.product.set_view_mode', 1) }}">Maak zichtbaar</option>
                                    <option value="{{ route('admin.product.set_sold_out', 1) }}">Zet op uitverkocht</option>
                                    <option value="{{ route('admin.product.set_sold_out', 0) }}">Zet op beschikbaar</option>
                                </select>
                                <select class="form-control ml-4 filter-visible">
                                    <option value="all">Toon</option>
                                    <option value="visible">Toon zichtbare producten</option>
                                    <option value="invisible">Toon niet zichtbare producten</option>
                                </select>
                                <script type="text/javascript">
                                    $(function(){
                                        $('.filter-visible').on('change', function(){
                                            $('.product').addClass('d-none');

                                            if ($(this).val() == 'all')
                                            {
                                                $('.product').removeClass('d-none');
                                            }
                                            if ($(this).val() == 'visible')
                                            {
                                                $('.table').find('[data-visible="visible"]').removeClass('d-none');
                                            }
                                            if ($(this).val() == 'invisible')
                                            {
                                                $('.table').find('[data-visible="invisible"]').removeClass('d-none');
                                            }
                                            //d
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.product.create') }}">Product toevoegen</a>
                </div>
                <div class="card-body">
                    <div class="filters">
                        <form method="post" action="{{ route('admin.product.set_variation_filter') }}">
                            @csrf
                            <div class="card-deck">
                                @foreach ($variations as $variation)
                                    @if ($variation->hide == 0)
                                        <div class="card mb-4">
                                            <div class="card-header font-weight-bold py-1">{{ t($variation, 'title') }}</div>
                                            <div class="card-body pb-2 px-3 pt-2 mb-0">
                                                @foreach ($variation->values as $value)
                                                    <div class="form-check">
                                                        @php $checked = isset($active_variations[$variation->slug]) && in_array($value->slug, explode(',', $active_variations[$variation->slug])) ? 'checked' : '' @endphp
                                                        <input type="checkbox" {{ $checked }} name="variations[{{ $variation->slug }}][]" class="form-check-input" value="{{ $value->slug }}" id="{{ $value->title }}">
                                                        <label class="form-check-label" for="{{ $value->title }}">{{ t($value, 'title') }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </form>
                    </div>

                    <script>
                    $(function(){
                        $('.filters input[type="checkbox"]').change(function(){
                            $('.filters form').submit();
                        });
                    });
                    </script>

                    <table class="table table-hover" data-range="true" data-toggle="checkboxes">
                        <thead>
                            <tr>
                                <th scope="col" class="border-top-0">
                                    <script type="text/javascript">
                                    $(function(){
                                        $('[name="check_all"]').on('click', function(){
                                            if($(this).prop('checked') == true)
                                            {
                                                $('.check').prop('checked', true);
                                            }
                                            else
                                            {
                                                $('.check').prop('checked', false);
                                            }
                                        });
                                    });
                                    </script>
                                    <input type="checkbox" name="check_all" value="1">
                                </th>
                                <th scope="col" class="border-top-0">SKU</th>
                                <th scope="col" class="border-top-0">Productnaam</th>
                                <th scope="col" class="border-top-0">Link</th>
                                <th scope="col" class="border-top-0">

                                </th>
                                <th scope="col" class="border-top-0">Prijs</th>
                                <th scope="col" class="border-top-0"></th>
                                <th scope="col" class="border-top-0">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="product" data-visible="{{  $product->visible == 0 ? 'invisible' : 'visible' }}">
                                    <td><input type="checkbox" class="check" name="ids[]" value="{{ $product->id }}"></td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{!! $product->visible == 0 ? '<i class="fas fa-eye-slash"></i>' : '' !!} <a href="{{ route('admin.product.edit', $product) }}">{{ $product->title }}</a></td>
                                    <td class="small">product/{{ $product->slug }}</td>
                                    <td class="small">
                                        <?php echo $product->sold_out == 1 ? '<span class="text-danger">Uitverkocht</span>' : '' ?>
                                    </td>
                                    <td>&euro; {{ $product->price }}</td>
                                    <td class="small">
                                        @foreach ($product->ordered() as $rule)
                                            @foreach (\App\Models\Variation::where('show_ordered', 1)->get() as $variation)
                                                {{ $rule->sum }}x {{ @$rule->options[$variation->id] }}<br>
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product.destroy', $product) }}" onclick="return confirm('Product verwijderen?')">verwijder</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
