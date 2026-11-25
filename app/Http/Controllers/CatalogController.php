<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use App\Models\Dlc;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function games()
    {
        return response()->json(Game::all());
    }

    public function categories()
    {
        return response()->json(Category::all());
    }

    public function index(Request $request)
    {
        $request->validate([
            'game_id' => 'nullable|integer|exists:games,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'search' => 'nullable|string|max:255',
        ]);

        $query = Dlc::with(['game', 'category']);

        if ($request->filled('game_id')) {
            $query->where('game_id', $request->game_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where(
                'title', 'ilike', '%' . $request->search . '%'
            );
        }

        return response()->json(
            $query->orderBy('id')->get()
        );
    }

    public function show($id)
    {
        $dlc = Dlc::with(['game', 'category'])
            ->findOrFail($id);

        return response()->json($dlc);
    }
}
