<?php

namespace App\Handler;

use Psr\Container\ContainerInterface;
use AmoCRM\Client\AmoCRMApiClient;

class FormHandlerFactory
{
    public function __invoke(ContainerInterface $container): FormHandler
    {
        /**
         * @var ContainerInterface $container
         * Достаем клиентские данные из автозагрузки
         */

        $clientId = $container->get('config')['clientId'];
        $clientSecret = $container->get('config')['clientSecret'];
        $redirectUri = $container->get('config')['redirectUri'];

        // Создаем api- клиент

        $apiClient = new \AmoCRM\Client\AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        return new FormHandler($apiClient);
    }
}
