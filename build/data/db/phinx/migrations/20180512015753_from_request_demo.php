<?php


use Phinx\Migration\AbstractMigration;

class FromRequestDemo extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $posts = $this->table('form_request_demo');
        $posts->addColumn('application_id', 'string', array('limit' => 64))
            ->addColumn('name_first', 'string', array('limit' => 64))
            ->addColumn('name_last', 'string', array('limit' => 64))
            ->addColumn('contact_phone', 'string', array('limit' => 64))
            ->addColumn('contact_email', 'string', array('limit' => 255))
            ->addColumn('venue_name', 'string', array('limit' => 255))
            ->addColumn('work_title', 'string', array('limit' => 16))
            ->addColumn('country', 'string', array('limit' => 32))
            ->addColumn('ip', 'string', array('limit' => 64))
            ->addColumn('created', 'datetime')
            ->create()
        ;
    }
}
