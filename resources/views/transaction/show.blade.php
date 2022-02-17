@extends('layouts.app')
@section('content')
    <main class="sm:container sm:mx-auto sm:mt-10">
        <div class="w-full py-6 sm:p-6 flex flex-col space-y-6">
            <nav aria-label="Progress">
                <ol class="border border-gray-300 rounded-md divide-y divide-gray-300 md:flex md:divide-y-0">
                    <li class="relative md:flex-1 md:flex">
                        <a href="{{ route('cart.index') }}" class="group flex items-center w-full">
                          <span class="px-6 py-4 flex items-center text-sm font-medium">
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
                              <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                              </svg>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900">Shopping Cart</span>
                          </span>
                        </a>
                  
                        <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                          <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </li>

                    <li class="relative md:flex-1 md:flex">
                        <a href="{{ route('transaction.create') }}" class="group flex items-center w-full">
                          <span class="px-6 py-4 flex items-center text-sm font-medium">
                            <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-indigo-600 rounded-full group-hover:bg-indigo-800">
                              <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                              </svg>
                            </span>
                            <span class="ml-4 text-sm font-medium text-gray-900">Transaction Information</span>
                          </span>
                        </a>
                  
                        <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                          <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none" preserveAspectRatio="none">
                            <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor" stroke-linejoin="round" />
                          </svg>
                        </div>
                      </li>

                      <li class="relative md:flex-1 md:flex">
                        <a href="{{ route('transaction.show', compact('transaction')) }}" class="px-6 py-4 flex items-center text-sm font-medium" aria-current="step">
                            <span
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
                                <span class="text-indigo-600">03</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-indigo-600">Transaction Receipt</span>
                        </a>

                    </li>
                </ol>
            </nav>
            <div class="flex flex-col gap-4">
                <span class="text-2xl font-bold">Transaction Receipt</span>
                <div class="bg-white rounded p-2 divide-y flex flex-col">
                    <div class="flex flex-col leading-5 gap-4 p-4">
                        <span>Transaction ID: {{ $transaction->id }}</span>
                        <span>Purchased Date: {{ $transaction->created_at }}</span>
                    </div>
                    @php
                        $total = 0;
                    @endphp
                    @forelse ($transaction->details as $details)
                    @php
                        $game = $details->game;
                        $total += $game->price;
                    @endphp
                    <div class="p-4 flex flex-row gap-4 items-center">
                        <a href="{{ route('games.show', compact('game')) }}">
                            <img src="{{ Storage::url('public/games/cover/' . $game->cover) }}" alt="" class="w-48 h-28 object-cover">
                        </a>
                        <div class="flex flex-col gap-2 flex-1 truncate">
                            <div class="flex flex-row items-center gap-2">
                                <span class="rounded-full font-semibold text-xs bg-gray-500 text-white px-3 py-1">{{ $game->category->name }}</span>
                                <span class="font-semibold text-lg">{{ $game->name }}</span>
                            </div>
                            <span>IDR {{ number_format($game->price, 0, '', '.') }}</span>
                        </div>
                        <form action="{{ route('cart.destroy', ['cart' => $game]) }}" method="post">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                  </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="p-4 text-center">No game in the cart!</div>
                    @endforelse
                        <div class="flex flex-col p-4 gap-4">
                            <div class="flex flex-row gap-2 items-center">
                                <span>Total Price</span>
                                <span class="text-lg font-semibold">IDR {{ number_format($total, 0, '', '.') }}</span>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </main>
@endsection
