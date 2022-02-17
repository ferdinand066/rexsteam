<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function index()
    {
        if (Cookie::get($this->cookieName) == null){
            $games = [];
        } else {
            $gameList = json_decode(Cookie::get($this->cookieName));
            $games = Game::whereIn('id', $gameList)->get();
        }
        return view('cart.index', compact('games'));
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
            'game_id' => 'required|exists:games,id'
        ]);
        
        $expiredMinutes = 60 * 2;
        if (Cookie::get($this->cookieName) == null){
            $gameList = [$validated['game_id']]; 
        } else {
            $gameList = json_decode(Cookie::get($this->cookieName));
            if (in_array($validated['game_id'], $gameList)){
                return redirect()->route('games.index')->withErrors('Item already in your cart!');
            }
            array_push($gameList, $validated['game_id']);
        }
        $gameList = json_encode($gameList);
        Cookie::queue($this->cookieName, $gameList, $expiredMinutes);

        return redirect()->route('games.index')->with('success', 'Successfully insert game to cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $cart)
    {
        $gameList = json_decode(Cookie::get($this->cookieName));
        if (($key = array_search($cart->id, $gameList)) !== false) {
            unset($gameList[$key]);
            $gameList = array_values($gameList);
        }
        
        if (count($gameList) == 0){
            $cookie = Cookie::forget($this->cookieName);
            return redirect()->back()->withCookie($cookie);
        }
        $expiredMinutes = 60 * 2;
        Cookie::queue($this->cookieName, json_encode($gameList), $expiredMinutes);

        return redirect()->back();
    }
}
