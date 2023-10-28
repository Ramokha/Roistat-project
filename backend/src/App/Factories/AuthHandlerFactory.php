<?php

namespace App\Handler;

use Psr\Container\ContainerInterface;
use AmoCRM\Client\AmoCRMApiClient;

class AuthHandlerFactory
{
    public function __invoke(ContainerInterface $container): ?AuthHandler
    {
        /**
         * @var \AmoCRM\Client\AmoCRMApiClient
         * Получаем клиентские данные из автозагрузки
         */

        $clientId = $container->get('config')['clientId'];
        $clientSecret = $container->get('config')['clientSecret'];
        $redirectUri = $container->get('config')['redirectUri'];
        $authorizationCode = $container->get('config')['authorizationCode'];
        $baseDomain = $container->get('config')['baseDomain'];

        // Создаем api- клиент

        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        return new AuthHandler($apiClient, $authorizationCode, $baseDomain);
    }
}
