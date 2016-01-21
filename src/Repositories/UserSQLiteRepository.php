<?php


namespace Scheduler\Repositories;

class UserSQLiteRepository extends SQLiteRepositoryBase
{
    /**
     * UserSQLiteRepository constructor.
     * @param $databaseFile
     */
    public function __construct($databaseFile)
    {
        parent::__construct($databaseFile,'users', 'User', 'name');
    }
}