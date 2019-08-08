<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Character extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'dex_bonus', 'max_hp', 'type',
    ];

    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }
}
