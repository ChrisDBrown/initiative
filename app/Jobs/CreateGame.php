<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Game;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CreateGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $userId;

    public function __construct(string $name, int $userId)
    {
        $this->name = $name;
        $this->userId = $userId;
    }

    public function handle(): int
    {
        $user = User::find($this->userId);

        if (!$user instanceof User) {
            throw new \InvalidArgumentException(
                sprintf('No user found with ID %s when trying to create a game', $this->userId)
            );
        }

        $data = [
            'name' => $this->name,
            // need to make this uniquely safe
            'url_code' => $this->generateUrlCode(),
        ];

        return $user->games()->create($data)->id;
    }

    private function generateUrlCode(): string
    {
        do {
            $urlCode = Str::random(10);
        } while (Game::where('url_code', '=', $urlCode)->exists());

        return $urlCode;
    }
}
