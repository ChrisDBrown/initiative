<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    public function view(string $urlCode): Renderable
    {
        $game = Game::where(['url_code' => $urlCode])->firstOrFail();

        return view('game.view', ['game' => $game]);
    }

    public function apiView(string $urlCode): JsonResponse
    {
        $game = Game::where(['url_code' => $urlCode])->firstOrFail();

        return response()->json($game);
    }
}
