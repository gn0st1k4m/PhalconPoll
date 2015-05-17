<?php

namespace PhalconPoll\Models;

/**
 * HyperLogLog IP紀錄
 * @author Peter Chung <touhonoob@gmail.com>
 * @date Apr 16, 2015
 */
class PollLogs extends RedisModel
{

    private $poll_id;

    public function __construct($poll_id)
    {
        $this->poll_id = $poll_id;
    }

    public function add($ip_hex)
    {
        return self::r()->pfadd($this->key(), [$ip_hex]);
    }

    public function count()
    {
        return self::r()->pfcount($this->key());
    }

    public function key()
    {
        return "poll_logs:{$this->poll_id}";
    }
}
