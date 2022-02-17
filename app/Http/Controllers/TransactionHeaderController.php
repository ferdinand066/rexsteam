<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use App\Rules\CardFormat;
use App\Rules\NumberFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TransactionHeaderController extends Controller
{
    protected $cookieName;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            $this->cookieName = 'cart_' . Auth::user()->id;
     
            return $next($request);
        });
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cookie::get($this->cookieName) == null){
            return redirect()->route('cart.index');
        }

        $gameList = json_decode(Cookie::get($this->cookieName));
        $total = Game::whereIn('id', $gameList)->sum('price');
        
        return view('transaction.create', compact('total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_name' => 'required|min:6',
            'card_number' => ['required', new CardFormat],
            'expired_month' => 'required|integer|between:1,12',
            'expired_year' => 'required|integer|between:2021,2050',
            'cvc_cvv' => ['required', new NumberFormat, 'digits_between:3,4'],
            'country' => 'required',
            'zip' => ['required', new NumberFormat]
        ]);

        $id = Str::uuid();

        $validated['id'] = $id;
        $validated['user_id'] = Auth::user()->id;
        $transaction = TransactionHeader::create($validated);

        $gameList = json_decode(Cookie::get($this->cookieName));
        $gameList = Game::whereIn('id', $gameList)->get();
        foreach($gameList as $game){
            TransactionDetail::create([
                'transaction_header_id' => $id,
                'game_id' => $game->id,
                'price' => $game->price
            ]);
        }

        $cookie = Cookie::forget($this->cookieName);

        return redirect()->route('transaction.show', compact('transaction'))->withCookie($cookie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionHeader  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionHeader $transaction)
    {
        if ($transaction->user_id !== Auth::user()->id){
            return redirect()->route('games.index')->withErrors('Invalid Transaction Invoice Request');
        }
        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionHeader  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionHeader $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionHeader  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionHeader $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionHeader  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionHeader $transaction)
    {
        //
    }
}
