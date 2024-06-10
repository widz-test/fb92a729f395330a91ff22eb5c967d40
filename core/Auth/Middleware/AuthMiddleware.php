<?php

namespace Core\Auth\Middleware;

use Closure;
use Core\Auth\Service\AuthGoogleService;
use Illuminate\Validation\UnauthorizedException;

class AuthMiddleware
{
    /**
     * @var AuthGoogleService
     */
    protected AuthGoogleService $googleOAuthService;

    /**
     * Constructor
     *
     * @param AuthGoogleService $googleOAuthService
     */
    public function __construct(AuthGoogleService $googleOAuthService)
    {
        $this->googleOAuthService = $googleOAuthService;
    }

    /**
     * Process
     *
     * @param $request
     * @param $next
     * @return mixed
     */
    public function process($request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization', '');
        
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            $accessToken = substr($authorizationHeader, 7);
            $user = $this->googleOAuthService->validateToken($accessToken);
            if ($user) {
                $request->attributes->set('user', $user);
                return $next($request);
            }
        }

        throw new UnauthorizedException("Unauthorized", 401);
    }
}
