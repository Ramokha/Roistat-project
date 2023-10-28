<?php

namespace App;

class Logger
{
    public function __construct(string $description)
    {
        /**
         * @var Logger
         * Вызываем метод записи описания ошибки в лог- файл
         */

        $this->addLog($description);
    }
    private function addLog(string $description): void
    {
        file_put_contents('errors', PHP_EOL . $description, FILE_APPEND);
    }
}
