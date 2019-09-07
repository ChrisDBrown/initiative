<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Illuminate's authenticate middleware doesn't allow us to strictly type the parameter here
     * phpcs:disable SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request): string
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
    // // phpcs:enable
}
