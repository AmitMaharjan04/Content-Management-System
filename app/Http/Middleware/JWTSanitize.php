<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTSanitize extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Parse the token from the request
        $token = $this->auth->parseToken();

        // Check if the token is valid and not expired
        if ($this->auth->check()) {
            // Get the token payload
            $payload = $this->auth->payload();

            // Remove the `password` claim from the payload
            unset($payload['password']);

            // Set the new payload on the token
            $token->setPayload($payload);
        }

        // Continue processing the request
        return $next($request);
    }
}
