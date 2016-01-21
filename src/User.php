<?php

namespace Scheduler;
use Scheduler\Validation\UserValidator;

class User extends DomainEntity {
    protected $id;
    protected $name;
    protected $role;
    protected $email;
    protected $phone;
    protected $createdAt;
    protected $updatedAt;
    const MANAGER = 'manager';
    const EMPLOYEE = 'employee';
    protected $attributes = [
        'id',
        'name',
        'role',
        'phone',
        'email',
        'created_at',
        'updated_at'
    ];



    function __construct(Array $params, UserValidator $validator)
    {
        $this->params = $params;
        $this->fromParams();
        parent::__construct($validator);
    }


}