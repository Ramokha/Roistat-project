<?php

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\AmoRequest;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class FormHandler
{
    /**
     * @var AmoCRMApiClient
     */

    protected AmoCRMApiClient $apiClient;

    public function __construct(AmoCRMApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    public function handle(ServerRequestInterface $request): ?JsonResponse
    {
        /**
         * @var ServerRequestInterface
         * Получаем данные формы из тела запроса
         */

        $requestBody = $request->getParsedBody();
        $name = $requestBody['name'];
        $email = $requestBody['email'];
        $phone = $requestBody['phone'];
        $price = $requestBody['price'];

        // Создаем объект класса AmoRequest и вызываем метод комплексного создания сделок

        $amoRequest = new AmoRequest();
        return $amoRequest->postRequestLeadsComplex($name, $email, $phone, $price, $this->apiClient);
    }
}
