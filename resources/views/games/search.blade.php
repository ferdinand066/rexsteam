@extends('layouts.app')
@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full py-6 sm:p-6 flex flex-col space-y-4">
        <h3 class="text-xl sm:text-3xl font-bold">Search Games</h3>
        @if(count($games) == 0)
        <section>
            There are no games content can be showed right now
        </section>
        @else
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($games as $game)
            <a href="{{ route('restrict.index', compact('game')) }}" class="col-span-1 flex flex-col space-y-1 shadow-lg">
                <div class="relative rounded">
                    <img src="{{ Storage::url('public/games/cover/' . $game->cover) }}" alt="" class="object-cover w-full h-48 rounded">
                    <div class="absolute bottom-0 left-0 w-full">
                        <div class="bg-gray-300 flex flex-col m-1 p-1.5 space-y-1" style="background-color: #f3f4f690">
                            <span class="font-semibold truncate w-full">{{ $game->name }}</span>
                            <span>{{ $game->category->name }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </section>
        {{ $games->links() }}
        @endif
    </div>
</main>
@endsection