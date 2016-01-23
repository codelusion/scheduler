<?php

require __DIR__ . '/../vendor/autoload.php';

use \Scheduler\Repositories\UserSQLiteRepository;
use Scheduler\Services\UserService;
use Scheduler\Validation\UserValidator;
use Scheduler\Validation\ValidationHelper;
use Symfony\Component\Validator\ValidatorBuilder;

$app = new Proton\Application();

$app['database'] = __DIR__.'/../DB/scheduler.db';

$app['user_repository'] = function () use ($app) {
    return new UserSQLiteRepository($app['database']);
};

$app['validation_helper'] = function () use ($app) {
    $validatorBuilder = new ValidatorBuilder();
    $validator = $validatorBuilder->getValidator();
    return new ValidationHelper($validator);
};

$app['user_validator'] = function () use ($app) {
    return new UserValidator($app['validation_helper']);
};

$app['user_service'] = function () use ($app) {
    return new UserService($app['user_repository'], $app['user_validator']);
};
