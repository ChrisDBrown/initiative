<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [
        'App\Game' => 'App\Policies\GamePolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
