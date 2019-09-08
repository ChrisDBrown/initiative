<?php
declare(strict_types=1);

namespace App\Policies;

use App\Game;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function create(): bool
    {
        return true;
    }

    public function update(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function delete(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function restore(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    public function forceDelete(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }
}
