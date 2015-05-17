<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class PollItemsMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'poll_items',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'poll_id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'text',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 140,
                        'after' => 'poll_id'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id')),
                new Index('poll_id', array('poll_id'))
            ),
            'references' => array(
                new Reference('poll_items_ibfk_1', array(
                    'referencedSchema' => 'phalcon_poll',
                    'referencedTable' => 'polls',
                    'columns' => array('poll_id'),
                    'referencedColumns' => array('id'),
                    'onDelete' => 'CASCADE',
                    'onUpdate' => 'RESTRICT'
                ))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'utf8_general_ci'
            )
        )
        );
    }
}
