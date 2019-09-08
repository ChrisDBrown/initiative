<?php
declare(strict_types=1);

namespace App\Services;

use App\Events\GameStateUpdateEvent;
use App\Game;

class GameStateService
{
    const STATE_OUT_OF_COMBAT = 'OUT_OF_COMBAT';
    const STATE_ROLLING_INITIATIVE = 'ROLLING_INITIATIVE';
    const STATE_IN_COMBAT = 'IN_COMBAT';
    const STATE_ORDER = [
        self::STATE_OUT_OF_COMBAT,
        self::STATE_ROLLING_INITIATIVE,
        self::STATE_IN_COMBAT,
    ];

    public function forwardGameState(Game $game): void
    {
        $nextState = $this->getNextState($game->state);

        $game->state = $nextState;
        $game->save();

        event(new GameStateUpdateEvent($game));
    }

    private function getNextState(string $currentState): string
    {
        $currentStatePosition = array_search($currentState, self::STATE_ORDER, true);

        if ($currentStatePosition === false) {
            throw new \InvalidArgumentException(sprintf('State %s is unknown', $currentState));
        }

        if (isset(self::STATE_ORDER[$currentStatePosition + 1])) {
            return self::STATE_ORDER[$currentStatePosition + 1];
        }

        return self::STATE_ORDER[0];
    }
}
