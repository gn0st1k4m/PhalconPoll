<?php

namespace PhalconPoll\Tests\Poll\Models;

use PhalconPoll\Models\PollItemsCount;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date May 15, 2015
 */
class PollItemsCountTest extends \PHPUnit_Framework_TestCase
{

    const POLL_ID = 1;

    private $faker;
    private $pollItemsCount;

    public function setUp()
    {
        $this->faker = (new \Faker\Factory)->create();
        $this->pollItemsCount = new PollItemsCount(self::POLL_ID);
    }

    public function tearDown()
    {
        $this->pollItemsCount->del();
    }

    public function testAdd()
    {
        $poll_item_id = 1;
        $c = rand(1, 50);
        for($i = 0;$i < $c;$i++) {
            $this->pollItemsCount->add($poll_item_id);
        }
        $this->assertEquals($c, $this->pollItemsCount->get($poll_item_id));
    }
}
