<?php

namespace PhalconPoll;

use PhalconPoll\Models\Polls;
use PhalconPoll\Models\PollItems;
use PhalconPoll\Models\PollItemsCount;
use PhalconPoll\Models\PollLogs;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date May 15, 2015
 */
class PollService extends \Phalcon\DI\Injectable
{

    /**
     *
     * @param string $title
     * @param array $items
     * @throws \Phalcon\Db\Exception
     * @throws \InvalidArgumentException
     * @return Polls|false
     * @todo Log rollbacks
     */
    public function create($title, array $items)
    {
        if (sizeof($items) === 0) {
            throw new \InvalidArgumentException("sizeof(\$items) === 0");
        }

        $this->di['db']->begin();

        $poll = new Polls;
        $poll->title = $title;
        if ($poll->save() === false) {
            $this->di['db']->rollback();
            return false;
        }

        foreach ($items as $item) {
            $poll_item = new PollItems;
            $poll_item->poll_id = $poll->id;
            $poll_item->text = $item;

            if ($poll_item->save() === false) {
                $this->di['db']->rollback();
                return false;
            }
        }

        $this->di['db']->commit();

        return $poll;
    }

    /**
     *
     * @param int $poll_id
     * @return bool
     */
    public function delete($poll_id)
    {
        $poll = Polls::findFirst($poll_id);
        if ($poll === false) {
            return false;
        }
        return $poll->delete();
    }

    /**
     *
     * @param int $poll_id
     * @return Polls
     */
    public function get($poll_id)
    {
        return Polls::findFirst($poll_id);
    }

    /**
     *
     * @param int $poll_item_id
     * @param string $ip
     * @return bool
     */
    public function vote($poll_item_id, $ip)
    {
        //Check PollItems Record
        $poll_item = PollItems::findFirst($poll_item_id);
        if ($poll_item === false) {
            return false;
        }

        //Check IP Logs
        $poll_logs = new PollLogs($poll_item->poll_id);
        if ($poll_logs->add(ip2hex($ip)) === false) {
            return false;
        }

        //Increase Item Count
        $poll_items_count = new PollItemsCount($poll_item->poll_id);
        return $poll_items_count->add($poll_item_id);
    }
}
