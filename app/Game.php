<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'url_code', 'state',
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
