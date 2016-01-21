<?php

require __DIR__ . '/../vendor/autoload.php';

use \Scheduler\Repositories\UserSQLiteRepository;

$app = new Proton\Application();
$app['database']  = '../DB/scheduler.db';

$app['userRepository'] =  function() use ($app) {
    return new UserSQLiteRepository($app['database']);
};
