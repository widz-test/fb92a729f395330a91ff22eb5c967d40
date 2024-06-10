<?php

namespace Core\Auth\Service;

use Core\Foundation\Config\Config;
use Illuminate\Validation\UnauthorizedException;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessToken;

class AuthGoogleService
{
    protected $provider;

    /**
     * Constructor
     */
    public function __construct()
    {
        $config = Config::get('oauth2.google');
        $this->provider = new Google([
            'clientId'     => data_get($config, 'client_id'),
            'clientSecret' => data_get($config, 'client_secret'),
        ]);
    }

    /**
     * Validate token
     *
     * @param string $accessToken
     * @return void
     */
    public function validateToken(string $accessToken)
    {
        try {
            $token = new AccessToken(['access_token' => $accessToken]);
            $user = $this->provider->getResourceOwner($token);
            return $user->toArray();
        } catch (\Exception $e) {
            // Handle token validation failure
            throw new UnauthorizedException("Unauthorized", 401);
        }
    }
}