@extends('layouts.app')
@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <div class="w-full py-6 sm:p-6 flex flex-col space-y-6">
         <div class="grid grid-cols-3 gap-4">
             <div class="col-span-3 sm:col-span-2">
                 <video src="{{ Storage::url('public/games/trailer/' . $game->trailer) }}" controls class="w-full"></video>
             </div>
             <div class="col-span-3 sm:col-span-1 flex flex-col space-y-2">
                 <img src="{{ Storage::url('public/games/cover/' . $game->cover) }}" class="w-full h-64 object-cover rounded" alt="">
                 <span class="text-3xl font-bold">{{ $game->name }}</span>
                 <span>{{ $game->short_desc }}</span>
                 <span><span class="font-semibold">Genre: </span>{{ $game->category->name }}</span>
                 <span><span class="font-semibold">Release Date: </span>{{ $game->created_at }}</span>
                 <span><span class="font-semibold">Developer: </span>{{ $game->developer }}</span>
                 <span><span class="font-semibold">Publisher: </span>{{ $game->publisher }}</span>
             </div>
         </div>
         @if($canBuy)
         <div class="bg-white shadow-lg py-4 px-8 flex flex-row justify-between items-center rounded">
             <span class="font-semibold">Buy {{ $game->name }}</span>
             <form action="{{ route('cart.store') }}" method="post">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                <button type="submit" class="flex flex-row py-2 bg-gray-800 text-white rounded divide-x-2 items-center text-center cursor-pointer">
                    <span class="py-1 px-4 font-semibold">IDR {{ number_format($game->price, 0, '', '.') }}</span>
                    <span class="py-1 px-4 font-semibold flex flex-row items-center">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                         </svg>
                        <span class="ml-2">ADD TO CART</span>
                   </span>
                </button>
             </form>
         </div>
         @endif
         <div class="flex flex-col divide-y-2">
             <span class="p-4 font-semibold">ABOUT THIS GAME</span>
             <div  class="p-4">{{ $game->long_desc }}</div>
         </div>
    </div>
</main>
@endsection