<?php


namespace Scheduler\Repositories;

use ORM;

use Scheduler\DomainEntity;

class SQLiteRepositoryBase implements IRepository
{

    const INTEGRITY_EXCEPTION = "23000";
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
        $DBModel = ORM::for_table($this->tableName)->create($entity->asArray());
        if (empty($DBModel->created_at)) {
            $DBModel->set('created_at', 'NOW()');
        }
        $DBModel->set('updated_at', 'NOW()');
        try {
            $DBModel->save();
            $display = $entity->asArray()[$this->entityDisplayAttribute];
            $result = ['result' => $DBModel->id(), 'message' => "{$this->entityName}: {$display} successfully saved"];
        } catch (\PDOException $e) {
            if ($e->getCode() == self::INTEGRITY_EXCEPTION) {
                $result = ['result' => false, 'message' => implode(' - ', $e->errorInfo) ];
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

    public function find(Array $params)
    {
        return ORM::for_table($this->tableName)->where($params)->find_array();
    }
}