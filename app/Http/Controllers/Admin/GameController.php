<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Game;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GameController extends Controller
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

        // need to abstract this creation away from the controller into command/handler
        $data = [
            'name' => $request->name,
            // need to make this uniquely safe
            'url_code' => Str::random(10),
        ];

        $gameId = $user->games()->create($data)->id;

        return redirect() -> route('admin_game_view', ['game' => $gameId]);
    }
}
