<?php
declare(strict_types=1);

namespace App;

use App\Services\GameStateService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url_code',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'state' => GameStateService::STATE_ORDER[0],
    ];

    /**
     * @var array
     */
    protected $visible = [
        'name', 'url_code', 'state', 'created_at', 'updated_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
