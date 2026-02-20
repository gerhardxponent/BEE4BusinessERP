<?php

namespace App\TokenStore;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class TokenCache {
    public function storeTokens($accessToken, $user) 
    {
        //90 days
        $cookieDuration = 1440*90;
        
        Cookie::queue('accessToken', $accessToken->getToken(), $cookieDuration);
        Cookie::queue('refreshToken', $accessToken->getRefreshToken(), $cookieDuration);
        Cookie::queue('tokenExpires', $accessToken->getExpires(), $cookieDuration);
        Cookie::queue('msEmail', $user->getMail() ? $user->getMail() : $user->getUserPrincipalName(), $cookieDuration);

        session([
            // 'accessToken' => $accessToken->getToken(),
            // 'refreshToken' => $accessToken->getRefreshToken(),
            // 'tokenExpires' => $accessToken->getExpires(),
            'userName' => $user->getDisplayName(),
            // 'userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName(),
            'userTimeZone' => $user->getMailboxSettings()->getTimeZone()
        ]);

        // return $res;
    }

    public function clearTokens() 
    {
        // session()->forget('accessToken');
        // session()->forget('refreshToken');
        // session()->forget('tokenExpires');

        Cookie::expire('accessToken');
        Cookie::expire('refreshToken');
        Cookie::expire('tokenExpires');

        session()->forget('userName');
        session()->forget('userEmail');
        session()->forget('userTimeZone');
    }

    public function getAccessToken() 
    {
        // Check if tokens exist
        if (!Cookie::has('accessToken') ||
            !Cookie::has('refreshToken') ||
            !Cookie::has('tokenExpires')) {
          return '';
        }
    
        // Check if token is expired
        //Get current time + 5 minutes (to allow for time differences)
        $now = time() + 300;
        if (Cookie::has('tokenExpires') <= $now) {
            // Token is expired (or very close to it)
            // so let's refresh
        
            // Initialize the OAuth client
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => config('azure.appId'),
                'clientSecret'            => config('azure.appSecret'),
                'redirectUri'             => config('azure.redirectUri'),
                'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
                'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => config('azure.scopes')
            ]);
    
            try {
                $newToken = $oauthClient->getAccessToken('refresh_token', [
                    'refresh_token' => Cookie::get('refreshToken')
                ]);
        
                // Store the new values
                $this->updateTokens($newToken);
        
                return $newToken->getToken();
            }
            catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return '';
            }
        }
    
        // Token is still valid, just return it
        return Cookie::get('accessToken');
    }

    public function updateTokens($accessToken) 
    {
        // session([
        //   'accessToken' => $accessToken->getToken(),
        //   'refreshToken' => $accessToken->getRefreshToken(),
        //   'tokenExpires' => $accessToken->getExpires()
        // ]);

        $cookieDuration = 1440*90;

        Cookie::queue('accessToken', $accessToken->getToken(), $cookieDuration);
        Cookie::queue('refreshToken', $accessToken->getRefreshToken(), $cookieDuration);
        Cookie::queue('tokenExpires', $accessToken->getExpires(), $cookieDuration);
    }
}