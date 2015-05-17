<?php

namespace PhalconPoll\Models;

/**
 * Hash計數
 * @author Peter Chung <touhonoob@gmail.com>
 * @date Mar 30, 2015
 */
class PollItemsCount extends RedisModel
{

    private $poll_id;

    public function __construct($poll_id)
    {
        $this->poll_id = $poll_id;
    }

    public function add($poll_item_id)
    {
        return self::r()->hIncrBy($this->key(), $poll_item_id, 1);
    }

    public function get($poll_item_id)
    {
        return self::r()->hGet($this->key(), $poll_item_id);
    }

    public function key()
    {
        return "poll_count:{$this->poll_id}";
    }
}
