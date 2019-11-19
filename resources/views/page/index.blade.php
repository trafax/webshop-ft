@extends('layouts.website')

@section('content')

    @include('partials.create_bar', ['parent_id' => $page->id])

    <div class="{{ Auth::user() && Auth::user()->role == 'admin' ? 'sortable' : '' }}" data-action="{{ route('admin.block.sort') }}">
        @foreach ($page->blocks as $block)
            <div class="block position-relative" id="{{ $block->id }}">
                @php echo App\Http\Controllers\TextController::block($block); @endphp
            </div>
        @endforeach
    </div>

@endsection
