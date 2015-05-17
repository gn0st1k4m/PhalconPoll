<?php

namespace PhalconPoll\Models;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date Mar 29, 2015
 */
class Polls extends \Phalcon\Mvc\Model
{

    public $id;
    public $title;

    public function getSource()
    {
        return 'polls';
    }

    public function initialize()
    {
        $this->hasMany('id', 'PhalconPoll\Models\PollItems', 'poll_id', [
            'alias' => 'items'
        ]);
    }

    public function afterDelete()
    {
        (new PollLogs($this->id))->del();
        (new PollItemsCount($this->id))->del();
    }

    /**
     *
     * @param array $parameters
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getItems($parameters = ['order' => 'id asc'])
    {
        return $this->getRelated('items', $parameters);
    }
}
