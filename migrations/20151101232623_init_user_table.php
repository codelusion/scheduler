<?php

use Phinx\Migration\AbstractMigration;

class InitUserTable extends AbstractMigration
{
    public function change()
    {
        $users = $this->table('users');
        $users->addColumn('name', 'string', array('limit' => 500))
            ->addColumn('role', 'string', array('limit' => 255))
            ->addColumn('email', 'string', array('limit' => 500))
            ->addColumn('phone', 'string', array('limit' => 500))
            ->addColumn('created_at', 'datetime', array('default' => 'CURRENT_TIMESTAMP'))
            ->addColumn('updated_at', 'datetime', array('null' => true, 'default'=> 'CURRENT_TIMESTAMP'))
            ->addIndex(array('name', 'email', 'phone'), array('unique' => true))
            ->create();
    }
}
