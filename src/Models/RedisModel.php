<?php

namespace PhalconPoll\Models;

use Phalcon\Di;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date Mar 28, 2015
 */
abstract class RedisModel
{

    private static $redis;

    /**
     *
     * @return \Redis
     */
    protected static function r()
    {
        if (!isset(self::$redis)) {
            self::$redis = DI::getDefault()->get('redis');
        }

        return self::$redis;
    }

    public function del()
    {
        return self::r()->del($this->key());
    }

    public function exists()
    {
        return self::r()->exists($this->key());
    }

    abstract public function key();
}
