<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class HeaderDumper
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request instanceof Request) {
            $this->logger->info('request', [
                'header' => strval($request->headers),
            ]);
        }
        $response = $next($request);
        if ($response instanceof Response) {
            $this->logger->info('response', [
                'header' => strval($response->headers),
            ]);
        }
        
        return $response;
    }
}
