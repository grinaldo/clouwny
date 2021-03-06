<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class AdminAccess
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (($request->getRequestUri() !== '/backend/login' && 
             strpos($request->getRequestUri(), '/backend/password') ===false) &&
            ($this->auth->guest() || !$this->auth->user()->isAdmin())
        ) {
            session()->flash(NOTIF_DANGER, 'You don\'t privilege to access that page!');
            return redirect('/');
        }
        return $next($request);
    }
}
