<?php

namespace Scheduler\Services;


use Scheduler\Repositories\IRepository;
use Scheduler\User;
use Scheduler\Validation\UserValidator;

class UserService
{
    /** @var IRepository  */
    protected $userRepository;
    protected $userValidator;

    public function __construct(IRepository $repository, UserValidator $userValidator)
    {
        $this->userRepository = $repository;
        $this->userValidator = $userValidator;
    }

    public function addUser($params) {
        $user = new User($params, $this->userValidator);
        return $this->userRepository->save($user);
    }

    public function findAllUsers() {
        return $this->userRepository->findAll();
    }
}