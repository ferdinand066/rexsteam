@extends('layouts.user-tab')
@section('script')
<script>
    $(function () {
        $('#photo').on('change', evt => {
            $('#temp-img').remove()
            $('#new-img').removeClass('hidden')
            $('#new-img').attr('src', URL.createObjectURL(evt.target.files[0])) 
        })
    });
</script>
@endsection
@section('right-tab')
<div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
    <form action="{{ route('profile.update', ['profile' => Auth::user()]) }}" method="POST" enctype="multipart/form-data">
      @method('patch')
      @csrf
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
          <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ Auth::user()->username }} Profile</h3>
            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p>
          </div>

          <div class="grid grid-cols-8 gap-6">
            <div class="col-span-8 grid grid-cols-8 gap-6">
                <div class="col-span-8 sm:col-span-6 grid justify-end gap-6 grid-cols-4">
                    <div class="col-span-3">
                      <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                      <input type="text" value="{{ Auth::user()->username }}" disabled readonly name="username" id="username" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="col-span-1">
                      <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                      <input type="text" value="{{ Auth::user()->level }}" disabled readonly name="level" id="level" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="col-span-4">
                      <label for="full_name" class="block text-sm font-medium text-gray-700">Full name</label>
                      <input type="text" value="{{ Auth::user()->full_name }}" name="full_name" id="full_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="col-span-8 sm:col-span-2 order-first sm:order-last">
                  <label for="photo" class="block text-sm font-medium text-gray-700 flex flex-col h-full">
                      <span>Photo</span>
                      <div class="w-full h-full flex justify-center items-center">
                          <img id="new-img" src="@if(Auth::user()->photo != null) {{ Storage::url('public/profile/' . Auth::user()->photo) }} @endif" alt="" class="w-20 h-20 sm:w-28 sm:h-28 rounded-full @if(Auth::user()->photo == null) hidden @endif">
                          @if(Auth::user()->photo == null)
                          <svg id="temp-img" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 sm:w-28 sm:h-28 rounded-full bg-gray-200 p-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            @endif
                      </div>
                  </label>
                  <input type="file" name="photo" id="photo" accept="image/jpeg, image/png" class="hidden">
                </div>
            </div>

            <div class="col-span-8">
                <label for="old_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input required type="password" name="old_password" id="old_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <p class="mt-2 text-sm text-gray-500">
                    Fill out this field to check if you are authorized.
                </p>
            </div>

            <div class="col-span-8">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <p class="mt-2 text-sm text-gray-500">
                    Only if you want to change your password.
                </p>
            </div>

            <div class="col-span-8">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <p class="mt-2 text-sm text-gray-500">
                    Only if you want to change your password.
                </p>
            </div>

          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Update Profile
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection