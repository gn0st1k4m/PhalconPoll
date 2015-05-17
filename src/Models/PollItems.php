<?php

namespace PhalconPoll\Models;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date Apr 16, 2015
 */
class PollItems extends \Phalcon\Mvc\Model
{

    public $id;
    public $poll_id;
    public $text;

    public function getSource()
    {
        return 'poll_items';
    }

    public function initialize()
    {
        $this->belongsTo('poll_id', 'PhalconPoll\Models\Polls', 'id', [
            'alias' => 'poll'
        ]);
    }
}
