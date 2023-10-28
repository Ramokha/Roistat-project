<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use App\TokenAction;
use Laminas\Diactoros\Response\JsonResponse;

class Auth
{
    public function __construct(AmoCRMApiClient $apiClient, string $authorizationCode, string $baseDomain)
    {
        // Вызов метода авторизации

        $this->getAuth($apiClient, $authorizationCode, $baseDomain);
    }
    private function getAuth(AmoCRMApiClient $apiClient, string $authorizationCode, string $baseDomain): ?JsonResponse
    {
        try {

            // Устанавливаем домен, к которому будет прикреплен токен доступа

            $apiClient->setAccountBaseDomain("https://" . $baseDomain . "amocrm.ru");

            // Обмениваем код авторизации на токен доступа

            $token = $apiClient->getOAuthClient()->getAccessTokenByCode($authorizationCode);
            $tokenAction = new TokenAction();

            // Вызывем метод сохранения токена в БД

            $tokenAction->saveToken($token, $apiClient);
            return new JsonResponse('OK');
        } catch (AmoCRMException $e) {
            new Logger($e->getMessage());
            return new JsonResponse('Error');
        }
    }
}
