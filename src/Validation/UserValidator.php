<?php

namespace Scheduler\Validation;


use Scheduler\DomainEntity;
use Scheduler\User;

class UserValidator implements IEntityValidator
{
    protected $helper;

    public function __construct(ValidationHelper $helper)
    {
        $this->helper = $helper;
    }

    public function validate(DomainEntity $user) {

        if (!$this->helper->validate($user->name, 'name')) {
            throw new \InvalidArgumentException('name is invalid');
        }

        if ($user->email && !$this->helper->validate($user->email, 'email')) {
            throw new \InvalidArgumentException('email is invalid');
        }

        if ($user->phone && !$this->helper->validate($user->phone,'phone')) {
            throw new \InvalidArgumentException('phone is invalid');
        }

        if (!in_array($user->role, [User::MANAGER, User::EMPLOYEE])) {
            throw new \InvalidArgumentException('role is invalid');
        }

        if (!$user->phone && !$user->email) {
            throw new \InvalidArgumentException('either phone or email required');
        }
    }



}