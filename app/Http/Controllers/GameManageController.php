<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Request;

class GameManageController extends Controller
{
    public function index(){
        $games = Game::where('name', 'like', '%' . 
            (request()->exists('search') ? request()->get('search') : '') . '%');
        
        if (request()->exists('category')){
            $games = $games->whereIn('category_id', request()->get('category'));
        }

        $games = $games->paginate(8)->withQueryString();
        
        $categories = Category::all();
        return view('manage.game.index', compact('categories', 'games'));
    }
}
