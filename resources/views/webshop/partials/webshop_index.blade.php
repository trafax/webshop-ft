<div class="card-deck">
    @foreach ($categories as $key => $category)
        <div class="card category mb-4">
            @if (isset($category->image) && $category->image)
                <div class="image" style="background-image: url('{{ $category->image }}')"></div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{!! t($category, 'title') !!}</h5>
                {{-- <p class="card-text">{!! $category->description !!}</p> --}}
                <a href="{{ route('category', $category->slug) }}" class="stretched-link"></a>
            </div>
        </div>
        {!! ($key+1) % 4 == 0 ? '</div><div class="card-deck">' : '' !!}
    @endforeach
</div>
