<?php
declare(strict_types=1);

namespace App\Events;

use App\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameStateUpdateEvent implements ShouldBroadcast
{
    /**
     * @var Game
     */
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function broadcastOn(): Channel
    {
        return new Channel(sprintf('Game.%s', $this->game->url_code));
    }

    public function broadcastAs(): string
    {
        return 'game.state_updated';
    }

    public function broadcastWith(): array
    {
        return $this->game->toArray();
    }
}
