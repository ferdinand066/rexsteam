@extends('layouts.app')
@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full py-6 sm:p-6 flex flex-col space-y-4">
        <h3 class="text-xl sm:text-3xl font-bold">Manage Games</h3>
        <form action="{{ route('manage.game') }}" class="flex flex-col space-y-4">
            <span class="font-semibold">Filter by Games Name</span>
            <div class="flex-1 flex items-center">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" name="search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Search" type="search">
                    </div>
                </div>
            </div>
            <span class="font-semibold">Filter by Games Category</span>
            <div class="grid grid-cols-5 gap-4">
                @foreach($categories as $key => $category)
                <div class="col-span-1 flex items-center">
                    <label class="inline-flex items-center text-sm" for="category_{{ $category->id }}">
                        <input type="checkbox" name="category[{{ $key }}]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="form-checkbox"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">{{ $category->name }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 w-24 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Search
            </button>
        </form>
        @if(count($games) == 0)
        <section>
            There are no games content can be showed right now
        </section>
        @else
        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($games as $game)
            <div class="col-span-1 flex flex-col space-y-1 shadow-lg">
                <div class="relative rounded">
                    <img src="{{ Storage::url('public/games/cover/' . $game->cover) }}" alt="" class="rounded object-cover w-full h-48">
                    <div class="absolute bottom-0 left-0 w-full">
                        <div class="bg-gray-300 flex flex-col m-1 p-1.5 space-y-1" style="background-color: #f3f4f690">
                            <span class="font-semibold truncate w-full">{{ $game->name }}</span>
                            <span>{{ $game->category->name }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('games.edit', compact('game')) }}" class="bg-white hover:bg-gray-50 rounded px-4 py-2">
                    Update
                </a>
                <form method="post" action="{{ route('games.destroy', compact('game')) }}" class="bg-white hover:bg-gray-50 rounded px-4 py-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-left focus:outline-none">Delete</button>
                </form>
            </div>
            @endforeach
        </section>
        {{ $games->links() }}
        @endif
    </div>
    <div class="fixed bottom-5 right-5">
        <a href="{{ route('games.create') }}" class="flex bg-indigo-600 hover:bg-indigo-700 cursor-pointer p-4 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </a>
    </div>
</main>
@endsection