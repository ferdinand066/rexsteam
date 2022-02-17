<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestrictController extends Controller
{
    public function index(Game $game){
        if (!$game->restrict) return redirect()->route('games.show', compact('game'));
        if ($game->restrict && session()->exists('adult')) return redirect()->route('games.show', compact('game'));
        return view('check-age.index', compact('game'));
    }

    public function show(Request $request, Game $game){
        $validator = Validator::make($request->all(), [
            'birthdate' => 'required|date|before_or_equal:' . now()->subYear(17)->format('Y-m-d')
        ]);

        if ($validator->fails()){
            return redirect()->route('games.index')->withErrors($validator);
        }
        
        session()->put('adult', true);

        return redirect()->route('games.show', compact('game'));
    }
}
