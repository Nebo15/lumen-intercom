<?php
namespace Nebo15\LumenIntercom\Middleware;

use Nebo15\LumenIntercom\Intercom;
use Closure;

class TerminableMiddleware
{
    private $intercom;

    public function __construct(Intercom $intercom)
    {
        $this->intercom = $intercom;
    }
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
    public function terminate($request, $response)
    {
        $this->intercom->sendCollectedEvents();
    }
}