<?php

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\Auth;
use Psr\Http\Message\ServerRequestInterface;

class AuthHandler
{
    /**
     * @var AmoCRMApiClient
     */

    protected AmoCRMApiClient $apiClient;
    protected string $authorizationCode;
    protected string $baseDomain;

    public function __construct (AmoCRMApiClient $apiClient, string $authorizationCode, string $baseDomain)
    {
        // Инициализируем данные для авторизации

        $this->apiClient = $apiClient;
        $this->authorizationCode = $authorizationCode;
        $this->baseDomain = $baseDomain;
    }
    public function handle(ServerRequestInterface $request): Auth
    {
        // Создаем объект класса авторизации и передаем необходимые данные

        return new Auth($this->apiClient, $this->authorizationCode, $this->baseDomain);
    }
}
