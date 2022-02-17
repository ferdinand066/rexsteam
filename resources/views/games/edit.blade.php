@extends('layouts.app')
@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <form action="{{ route('games.update', compact('game')) }}" method="post" enctype="multipart/form-data" class="w-full py-6 sm:p-6 flex flex-col space-y-4">
      @csrf  
      @method('PATCH')
        <div>
            <label for="short-desc" class="block text-sm font-medium text-gray-700">
                Game Description
              </label>
              <div class="mt-1">
                  <textarea name="short_desc" id="short-desc" cols="30" rows="3" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $game->short_desc }}</textarea>
                    <span class="text-xs text-gray-400">Write a single sentence about the game.</span>
                </div>
        </div>
        <div>
            <label for="long-desc" class="block text-sm font-medium text-gray-700">
                Game Long Description
              </label>
              <div class="mt-1">
                  <textarea name="long_desc" id="long-desc" cols="30" rows="10" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ $game->long_desc }}</textarea>
                    <span class="text-xs text-gray-400">Write a few sentences about the game.</span>
                </div>
        </div>
        <div>
            <label for="category-id" class="block text-sm font-medium text-gray-700">
                Category
              </label>
              <div class="mt-1">
                  <select name="category_id" id="category-id" class="form-select appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if($game->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                      @endforeach
                        
                  </select>
                </div>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">
                Game Price
              </label>
              <div class="mt-1">
                <input value="{{ $game->price }}" id="price" name="price" type="number" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
        </div>
        <div>
            <label for="cover" class="block text-sm font-medium text-gray-700">
                Game Cover
              </label>
              <div class="mt-1">
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                  <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                      <label for="cover" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span>Upload a picture</span>
                        <input id="cover" name="cover" type="file" class="sr-only" accept="image/jpeg">
                      </label>
                      <p class="pl-1">of the game cover here</p>
                    </div>
                    <p class="text-xs text-gray-500">
                      JPG to 100KB
                    </p>
                  </div>
                </div>
              </div>
        </div>
        <div>
            <label for="trailer" class="block text-sm font-medium text-gray-700">
                Game Trailer
              </label>
              <div class="mt-1">
                <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                  <div class="space-y-1 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                      </svg>
                    <div class="flex text-sm text-gray-600">
                      <label for="trailer" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span>Upload a video</span>
                        <input id="trailer" name="trailer" type="file" class="sr-only" accept="video/webm">
                      </label>
                      <p class="pl-1">of the game trailer here</p>
                    </div>
                    <p class="text-xs text-gray-500">
                      WEBM to 100MB
                    </p>
                  </div>
                </div>
              </div>
        </div>
        <div class="flex justify-end">
            <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </button>
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save
            </button>
        </div>
    </form>
</main>
@endsection