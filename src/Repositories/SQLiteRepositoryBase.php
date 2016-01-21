<?php


namespace Scheduler\Repositories;

use ORM;

use Scheduler\DomainEntity;

class SQLiteRepositoryBase
{

    const DUPLICATE_ENTRY = "23000";
    protected $tableName = '';
    protected $entityName = '';
    protected $entityDisplayAttribute = '';
    protected $databaseFile;

    public function __construct($databaseFile, $tableName, $entityName, $entityDisplayAttribute) {
            $this->databaseFile = $databaseFile;
            $this->tableName = $tableName;
            $this->entityName = $entityName;
            $this->entityDisplayAttribute = $entityDisplayAttribute;
            $this->validate();
            ORM::configure('sqlite:' . $databaseFile);
    }

    protected function validate() {
        foreach (['databaseFile', 'tableName', 'entityName', 'entityDisplayAttribute'] as $field) {
            if (empty($this->$field)) {
                throw new \InvalidArgumentException( $field . ' not provided');
            }
        }
    }

    public function save(DomainEntity $entity) {
        $DB = ORM::for_table($this->tableName)->create($entity->asArray());
        try {
            $DB->save();
            $result = ['result' => $DB->id(), 'message' => "{$this->entityName} successfully saved"];
        } catch (\PDOException $e) {
            if ($e->getCode() == self::DUPLICATE_ENTRY) {
                $result = ['result' => false, 'message' => "{$this->entityName}: {$this->entityDisplayAttribute} already exists"];
            } else {
                throw $e;
            }
        }

        return $result;
    }

    public function findAll()
    {
        return ORM::for_table($this->tableName)->find_array();
    }
}