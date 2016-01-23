<?php
/**
 * Created by PhpStorm.
 * User: ashok
 * Date: 1/20/16
 * Time: 9:25 PM
 */

namespace Scheduler\Repositories;


use Scheduler\DomainEntity;

interface IRepository
{
    public function save(DomainEntity $entity);
    public function findAll();
    public function find(Array $params);

}