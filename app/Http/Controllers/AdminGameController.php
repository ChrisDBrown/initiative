<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Contracts\Support\Renderable;

class AdminGameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Game $game): Renderable
    {
        $this->authorize('view', $game);

        return view('admin.game.view', ['game' => $game]);
    }

    public function create(): Renderable
    {
        $this->authorize('create', Game::class);

        return view('admin.game.create');
    }
}
