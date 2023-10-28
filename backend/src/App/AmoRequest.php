<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\JsonResponse;

class AmoRequest
{
    public function postRequestLeadsComplex (
        string $name, string $email, int $phone, int $price, AmoCRMApiClient $apiClient
    ): JsonResponse
    {
        // Создаем ссылку запроса

        $link = 'https://' . $apiClient->getAccountBaseDomain() . '/api/v4/leads/complex';

        // Создаем объект класса TokenAction и получаем токен из БД

        $token = new TokenAction();
        $accessToken = $token->getToken($apiClient);

        // Прописываем заголовки запроса

        $headers = [
            "Accept: application/json",
            'Authorization: Bearer ' . $accessToken->getToken(),
        ];

        // Прописываем тело запроса на комплексное создание сделки с контактом и компанией

        $body = [
                "name" => "New Lead",
                "price" => $price,
                "_embeeded" => [
                    "contacts" => [
                        [
                            "first_name" => $name,
                            "responsible_user_id" => "9596938",
                            "updated_by" => 0,
                            "custom_fields_values" => [
                                [
                                    "field_code" => "EMAIL",
                                    "values" => [
                                        "value" => $email
                                    ]
                                ],
                                [
                                    "field_code" => "PHONE",
                                    "values" => [
                                        "value" => $phone
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "companies" => [
                        [
                            "name" => "for example company"
                        ]
                    ]
                ]
        ];

        // Инициируем запрос

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($code < 200 || $code > 200) {
            new Logger("Не удалось создать сделку, сервер ответил $code статусом");
            return new JsonResponse($code);
        } else {
            return new JsonResponse($code);
        }
    }
}
