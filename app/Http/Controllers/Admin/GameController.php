<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Game;
use App\Http\Controllers\Controller;
use App\Jobs\CreateGame;
use App\Services\GameStateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * @var GameStateService
     */
    private $gameStateService;

    public function __construct(GameStateService $gameStateService)
    {
        $this->middleware('auth');
        $this->gameStateService = $gameStateService;
    }

    public function view(Game $game): Renderable
    {
        $this->authorize('view', $game);

        return view('admin.game.view', ['game' => $game]);
    }

    public function nextState(Game $game): RedirectResponse
    {
        $this->authorize('view', $game);

        $this->gameStateService->forwardGameState($game);

        return redirect()->route('admin_game_view', ['game' => $game->id]);
    }

    public function create(): Renderable
    {
        $this->authorize('create', Game::class);

        return view('admin.game.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Game::class);

        $user = Auth::user();

        if (is_null($user)) {
            throw new AuthorizationException('An authorized user is required to store a game');
        }

        $request->validate([
            'name' => 'required',
        ]);

        $gameId = CreateGame::dispatchNow($request->name, $user->id);

        return redirect()->route('admin_game_view', ['game' => $gameId]);
    }
}
