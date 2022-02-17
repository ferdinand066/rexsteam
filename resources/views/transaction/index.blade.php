@extends('layouts.user-tab')
@section('right-tab')
<div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
    <form action="{{ route('profile.update', ['profile' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
      @method('patch')
      @csrf
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
          <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Transaction History</h3>
          </div>
          <div class="flex flex-col divide-y">
            @forelse (Auth::user()->transactions as $transaction)
              <a href="{{ route('transaction.show', compact('transaction')) }}" class="flex flex-col py-4 gap-4">
                <div class="flex flex-col gap-2 leading-5">
                  <span>Transaction ID: <span class="font-semibold">{{ $transaction->id }}</span></span>
                  <span>Purchased Date: <span class="font-semibold">{{ $transaction->created_at }}</span></span>
                </div>
                <div class="flex flex-row gap-4 overflow-x-auto remove-scroll py-1">
                    @foreach ($transaction->details as $detail)
                      @php
                        $game = $detail->game;
                      @endphp
                          <img src="{{ Storage::url('public/games/cover/' . $game->cover) }}" alt="" class="w-48 h-28 object-cover rounded shrink-0" style="min-width: 12rem;">
                    @endforeach
                </div>
                <span class="flex flex-row gap-2 items-center">Total Price: <span class="text-lg font-semibold">IDR {{ number_format($transaction->total_price, 0, '', '.') }}</span></span>
              </a>
            @empty
              <span>Your transaction history is empty.</span>
            @endforelse
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection