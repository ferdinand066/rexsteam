@extends('layouts.user-tab')
@section('right-tab')
    <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
        <div>
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Friends</h3>
                    </div>
                    <div class="flex flex-col divide-y">
                        <div class="py-4 flex flex-col gap-4">
                            <span class="font-semibold text-lg">Add Friend</span>
                            <form method="post" action="{{ route('friend.store') }}" class="flex flex-col">
                                @csrf
                                <div class="flex-1 flex gap-2 items-center flex-row">
                                    <div class="flex-1">
                                        <input type="text" placeholder="Username" name="username" id="username" required
                                            class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-9 bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="py-4 flex flex-col gap-4">
                            <span class="font-semibold text-lg">Incoming Friend Request</span>
                            <div class="grid grid-cols-3 gap-6">
                                @forelse ($request as $r)
                                <div
                                    class="bg-gray-50 flex flex-col divide-y leading-6 col-span-3 sm:col-span-1 shadow-lg rounded">
                                    <div class="p-4 flex flex-col-reverse items-center lg:flex-row">
                                        <div class="flex flex-col flex-1 items-center lg:items-start">
                                            <span class="flex flex-row space-x-2 items-center">
                                                <span class="font-semibold flex items-center">{{ $r->friend(Auth::user()->id)->username }}</span>
                                                <span class="text-green-500 bg-green-100 px-1 rounded-xl text-xs">{{ $r->friend(Auth::user()->id)->level }}</span>
                                            </span>
                                            <span>{{ $r->friend(Auth::user()->id)->role }}</span>
                                        </div>
                                        @if($r->friend(Auth::user()->id)->photo != null)
                                            <img src="{{ Storage::url('public/profile/' . $r->friend(Auth::user()->id)->photo) }}" alt="" class="w-14 h-14 shrink-0 object-cover rounded-full">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 shrink-0 rounded-full bg-gray-200 p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex flex-row divide-x">
                                        <form action="{{ route('friend.update', ['friend' => $r]) }}" method="post" class="w-1/2">
                                            @csrf
                                            @method('put')
                                            <button class="w-full p-2">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('friend.destroy', ['friend' => $r]) }}" method="post" class="w-1/2">
                                            @csrf
                                            @method('delete')
                                            <button class="w-full p-2">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                    <div class="col-span-3">There is no incoming friend request</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="py-4 flex flex-col gap-4">
                            <span class="font-semibold text-lg">Pending Friend Request</span>
                            <div class="grid grid-cols-3 gap-6">
                                @forelse ($pending as $p)
                                <div
                                    class="bg-gray-50 flex flex-col divide-y leading-6 col-span-3 sm:col-span-1 shadow-lg rounded">
                                    <div class="p-4 flex flex-col-reverse items-center lg:flex-row">
                                        <div class="flex flex-col flex-1 items-center lg:items-start">
                                            <span class="flex flex-row space-x-2 items-center">
                                                <span class="font-semibold flex items-center">{{ $p->friend(Auth::user()->id)->username }}</span>
                                                <span class="text-green-500 bg-green-100 px-1 rounded-xl text-xs">{{ $p->friend(Auth::user()->id)->level }}</span>
                                            </span>
                                            <span>{{ $p->friend(Auth::user()->id)->role }}</span>
                                        </div>
                                        @if($p->friend(Auth::user()->id)->photo != null)
                                            <img src="{{ Storage::url('public/profile/' . $p->friend(Auth::user()->id)->photo) }}" alt="" class="w-14 h-14 shrink-0 object-cover rounded-full">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 shrink-0 rounded-full bg-gray-200 p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <form action="{{ route('friend.destroy', ['friend' => $p]) }}" method="post" class="flex flex-row divide-x">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="w-full p-2">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                                @empty
                                    <div class="col-span-3">There is no pending friend request</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="py-4 flex flex-col gap-4">
                            <span class="font-semibold text-lg">Your friends</span>
                            <div class="grid grid-cols-3 gap-6">
                                @forelse ($accept as $a)
                                <div
                                    class="bg-gray-50 flex flex-col divide-y leading-6 col-span-3 sm:col-span-1 shadow-lg rounded">
                                    <div class="p-4 flex flex-col-reverse items-center lg:flex-row">
                                        <div class="flex flex-col flex-1 items-center lg:items-start">
                                            <span class="flex flex-row space-x-2 items-center">
                                                <span class="font-semibold flex items-center">{{ $a->friend(Auth::user()->id)->username }}</span>
                                                <span class="text-green-500 bg-green-100 px-1 rounded-xl text-xs">{{ $a->friend(Auth::user()->id)->level }}</span>
                                            </span>
                                            <span>{{ $a->friend(Auth::user()->id)->role }}</span>
                                        </div>
                                        @if($a->friend(Auth::user()->id)->photo != null)
                                            <img src="{{ Storage::url('public/profile/' . $a->friend(Auth::user()->id)->photo) }}" alt="" class="w-14 h-14 shrink-0 object-cover rounded-full">
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 shrink-0 rounded-full bg-gray-200 p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                @empty
                                    <div class="col-span-3">There is no friend</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
