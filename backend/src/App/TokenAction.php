<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\TokenModel;
use League\OAuth2\Client\Token\AccessToken;

class TokenAction
{
    public function saveToken(AccessToken $accessToken, AmoCRMApiClient $apiClient): void
    {
        // Подключаемся к БД

        DBConnection::connect();

        // Сохраняем токен доступа в БД

        (new TokenModel())
            ->setAttribute('account_id', $apiClient->getCurrent()->getId())
            ->setAttribute('access_token', $accessToken->getToken())
            ->setAttribute('refresh_token', $accessToken->getRefreshToken())
            ->setAttribute('expires_in', $accessToken->getExpires())
            ->setAttribute('base_domain', $apiClient->getAccountBaseDomain());
    }
    public function getToken($apiClient): ?AccessToken
    {
        // Подключаемся к БД и достаем токен доступа

        DBConnection::connect();
        $token = TokenModel::where('account_id', $apiClient->getCurrent()->getId());

        if ($token) {
            $accessToken = new AccessToken([
                'access_token' => $token->access_token,
                'refresh_token' => $token->refresh_token,
                'expires' => $token->expires_in,
                'baseDomain' => $token->base_domain,
            ]);
            return $accessToken;
        } else {
            return null;
        }
    }
}
