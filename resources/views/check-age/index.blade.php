@extends('layouts.app')
@section('content')
<main class="sm:container sm:mx-auto sm:mt-10">
    <form method="post" action="{{ route('restrict.show', compact('game')) }}" class="w-full sm:p-6 flex flex-col space-y-4 items-center text-center">
        @csrf
        <div class="sm:max-w-2xl space-y-4 leading-6">
            <span class="font-semibold">CONTENT IN THIS PRODUCT MAY NOT BE APPROPRIATE FOR ALL AGES, OR MAY NOT BE APPROPRIATE FOR VIEWING AT WORK</span>
            <div class="w-full bg-gray-50 shadow px-4 py-8 flex flex-col space-y-4 rounded">
                <span>Please enter your birth date to continue:</span>
                <div>
                    <label for="birthdate" class="block text-sm font-medium text-gray-700">
                        Birthdate
                      </label>
                      <div class="mt-1">
                        <input id="birthdate" name="birthdate" type="date" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      </div>
                </div>
                <div class="flex justify-center">
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Page
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>
@endsection