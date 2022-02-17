<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\category;
use App\Models\TransactionHeader;
use App\Rules\ExtensionRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GameController extends Controller
{

    public $url;

    public function __construct()
    {
        $this->middleware('can:admin')->except(['index', 'search', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::inRandomOrder()->take(8)->get();
        return view('games.index', compact('games'));
    }

    public function search(){
        $games = Game::where('name', 'like', '%' . 
                (request()->exists('s') ? request()->get('s') : '') . '%')->paginate(8)->withQueryString();
        return view('games.search', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('games.create', compact('categories'));
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
            'name' => 'required|unique:games,name',
            'short_desc' => 'required|max:500',
            'long_desc' => 'required|max:2000',
            'category_id' => 'required|exists:categories,id',
            'developer' => 'required',
            'publisher' => 'required',
            'price' => 'required|integer|max:1000000',
            'cover' => ['required', 'mimes:jpeg', 'max:100', new ExtensionRule('jpg')],
            'trailer' =>['required', 'mimetypes:video/webm', 'max:100000', new ExtensionRule('webm')],
            'restrict' => 'nullable'
        ]);

        if(isset($validated['restrict']) && $validated['restrict'] == 'on'){
            $validated['restrict'] = true;
        }

        $temp = time() . '_' . $validated['name'] . '.';

        $file_name = $temp . 
                $request->cover->getClientOriginalExtension();     
            
        $validated['cover']->storeAs('public/games/cover', $file_name);
        $validated['cover'] = $file_name;

        $file_name = $temp . 
                $request->trailer->getClientOriginalExtension();     
            
        $validated['trailer']->storeAs('public/games/trailer', $file_name);
        $validated['trailer'] = $file_name;

        $validated['id'] = Str::uuid();

        Game::create($validated);
        return redirect()->back()->with('success', 'Success to insert new game!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        if(session()->missing('adult') && $game->restrict) return redirect()->route('restrict.index', compact('game'));

        session()->pull('adult');

        $canBuy = false;
        
        if (Auth::check()){
            $transaction = TransactionHeader::where('user_id', Auth::user()->id)
            ->whereHas('details', function($query) use ($game){
                $query->where('game_id', $game->id);
            })->get();
            $canBuy = count($transaction) == 0 ? true : false;
        }
        
        return view('games.show', compact('game', 'canBuy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $categories = Category::all();
        return view('games.edit', compact('game', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'short_desc' => 'required|max:500',
            'long_desc' => 'required|max:2000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|max:1000000',
            'cover' => ['nullable', 'mimes:jpeg', 'max:100', new ExtensionRule('jpg')],
            'trailer' =>['nullable', 'mimetypes:video/webm', 'max:100000', new ExtensionRule('webm')],
            'restrict' => 'nullable'
        ]);

        $temp = time() . '_' . $game->name . '.';

        if(isset($validated['cover'])){
            if (Storage::exists('public/games/cover/' . $game->cover)){
                Storage::delete('public/games/cover/' . $game->cover);
            }
            $file_name = $temp . 
            $request->cover->getClientOriginalExtension();     
        
            $validated['cover']->storeAs('public/games/cover', $file_name);
            $validated['cover'] = $file_name;
        }

        if(isset($validated['trailer'])){
            if (Storage::exists('public/games/trailer/' . $game->trailer)){
                Storage::delete('public/games/trailer/' . $game->trailer);
            }
            
            $file_name = $temp . 
            $request->trailer->getClientOriginalExtension();     
        
            $validated['trailer']->storeAs('public/games/trailer', $file_name);
            $validated['trailer'] = $file_name;
        }

        $game->update($validated);

        return redirect()->route('manage.game')->with('success', 'Success to update '. $game->name .'!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if (Storage::exists('public/games/trailer/' . $game->trailer)){
            Storage::delete('public/games/trailer/' . $game->trailer);
        }

        if (Storage::exists('public/games/cover/' . $game->cover)){
            Storage::delete('public/games/cover/' . $game->cover);
        }

        $name = $game->name;
        $game->delete();

        return redirect()->route('manage.game')->with('success', 'Success to delete ' . $name . ' from database!');
    }
}
