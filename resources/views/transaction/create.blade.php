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
                        <a href="{{ route('transaction.create') }}" class="px-6 py-4 flex items-center text-sm font-medium" aria-current="step">
                            <span
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-indigo-600 rounded-full">
                                <span class="text-indigo-600">02</span>
                            </span>
                            <span class="ml-4 text-sm font-medium text-indigo-600">Transaction Information</span>
                        </a>

                        <div class="hidden md:block absolute top-0 right-0 h-full w-5" aria-hidden="true">
                            <svg class="h-full w-full text-gray-300" viewBox="0 0 22 80" fill="none"
                                preserveAspectRatio="none">
                                <path d="M0 -2L20 40L0 82" vector-effect="non-scaling-stroke" stroke="currentcolor"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </li>

                    <li class="relative md:flex-1 md:flex">
                        <a href="#" class="group flex items-center">
                            <span class="px-6 py-4 flex items-center text-sm font-medium">
                                <span
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center border-2 border-gray-300 rounded-full group-hover:border-gray-400">
                                    <span class="text-gray-500 group-hover:text-gray-900">03</span>
                                </span>
                                <span class="ml-4 text-sm font-medium text-gray-500 group-hover:text-gray-900">Transaction
                                    Receipt</span>
                            </span>
                        </a>
                    </li>
                </ol>
            </nav>
            <form method="post" action="{{ route('transaction.store') }}" class="flex flex-col gap-8">
                @csrf
                <span class="text-2xl font-bold">Transaction Information</span>
                <div class="grid grid-cols-6 gap-6"> 
                    <div class="col-span-6">
                        <label for="card_name" class="block text-sm font-medium text-gray-700">Card Name</label>
                        <input required type="text" name="card_name" id="card_name" placeholder="Card Name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
        
                    <div class="col-span-6">
                        <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                        <input required type="text" name="card_number" id="card_number" placeholder="0000 0000 0000 0000" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <p class="mt-2 text-sm text-gray-500">
                            VISA or Master Card
                        </p>
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <label for="expired_month" class="block text-sm font-medium text-gray-700">Expired Date</label>
                        <input required type="number" min="1" max="12" name="expired_month" id="expired_month" placeholder="MM" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <label for="expired_year" class="block text-sm font-medium text-gray-700">&nbsp</label>
                        <input required type="number" min="2021" max="2050" name="expired_year" id="expired_year" placeholder="YYYY" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <label for="cvc_cvv" class="block text-sm font-medium text-gray-700">CVC / CVV</label>
                        <input required type="text" name="cvc_cvv" id="cvc_cvv" placeholder="3 or 4 digit number" pattern="[0-9]{3,4}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
        
                    <div class="col-span-6 sm:col-span-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                        <select name="country" id="country" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="indonesia">Indonesia</option>
                            <option value="malaysia">Malaysia</option>
                            <option value="singapore">Singapore</option>
                        </select>
                    </div>
        
                    <div class="col-span-6 sm:col-span-2">
                        <label for="zip" class="block text-sm font-medium text-gray-700">ZIP</label>
                        <input required type="text" name="zip" id="zip" placeholder="ZIP" pattern="[0-9]*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="py-3 text-right flex flex-row items-center justify-between">
                    <span>Total Price <span class="text-lg font-bold">IDR {{ number_format($total, 0, '', '.') }}</span></span>
                    <div class="flex flex-row items-center justify-end gap-4">
                        <a href="{{ route('cart.index') }}">
                            <button type="button" class="h-10 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                        </a>
                      <button type="submit" class="h-10 items-center bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                          </svg>
                        Checkout
                      </button>
                    </div>
                </div>
            </form>
                
              </div>
            </div>
        </div>
    </main>
@endsection
