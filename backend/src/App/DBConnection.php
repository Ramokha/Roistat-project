<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class DBConnection
{
    protected array $config;
    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }
    /**
     * @return void
     */
    public static function connect(): void
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost:3306',
            'database' => 'app_db',
            'username' => 'admin',
            'password' => '111111',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Set the event dispatcher used by Eloquent models... (optional)

        //$capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }
}
