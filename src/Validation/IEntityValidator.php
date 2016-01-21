<?php

namespace Scheduler\Validation;


use Scheduler\DomainEntity;

interface IEntityValidator
{
    public function validate(DomainEntity $entity);
}