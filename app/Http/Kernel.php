<?php

namespace Matchappen\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Matchappen\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Matchappen\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Matchappen\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.token' => \Matchappen\Http\Middleware\AuthenticateToken::class,
        'guest' => \Matchappen\Http\Middleware\RedirectIfAuthenticated::class,
        'reformulator.trim' => \FewAgency\Reformulator\Middleware\TrimInput::class,
        'reformulator.strip_repeats' => \FewAgency\Reformulator\Middleware\StripRepeatNonWordCharsFromInput::class,
        'reformulator.concatenate' => \FewAgency\Reformulator\Middleware\ConcatenateInput::class,
        'reformulator.explode' => \FewAgency\Reformulator\Middleware\ExplodeInput::class,
        'reformulator.datetime-local' => \FewAgency\Reformulator\Middleware\DatetimeLocalInput::class,
    ];
}