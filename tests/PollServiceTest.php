<?php

namespace PhalconPoll\Tests\Poll;

use PhalconPoll\Tests\BaseTestCase;
use PhalconPoll\PollService;
use PhalconPoll\Models\Polls;
use PhalconPoll\Models\PollLogs;
use PhalconPoll\Models\PollItemsCount;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date May 15, 2015
 */
class PollServiceTest extends BaseTestCase
{

    /**
     *
     * @var PollService
     */
    private $pollService;

    public function setUp()
    {
        parent::setUp();
        $this->pollService = new PollService;
    }

    public function tearDown()
    {
        global $di;
        parent::tearDown();
        $di['db']->query("DELETE FROM polls WHERE 1;");
        $di['db']->query("ALTER TABLE polls AUTO_INCREMENT = 1;");
        $di['db']->query("ALTER TABLE poll_items AUTO_INCREMENT = 1;");
    }

    private function generatePoll()
    {
        $title = $this->faker->word;
        $items = [];
        $size = rand(2, 10);
        for ($i = 0; $i < $size; $i++) {
            $items[] = $this->faker->word;
        }
        $poll = $this->pollService->create($title, $items);

        return [
            $poll,
            $title,
            $items
        ];
    }

    public function testCreate()
    {
        list($poll, $title, $items) = $this->generatePoll();

        //Check Poll Title
        $this->assertEquals($title, $poll->title);

        //Check Poll Items Count
        $this->assertEquals(sizeof($items), sizeof($poll->items));

        //Validate Poll Items Text
        foreach ($poll->items as $i => $item) {
            $this->assertEquals($items[$i], $item->text);
        }
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateEmpty()
    {
        $this->pollService->create("123", []);
    }

    public function testDelete()
    {
        $poll = $this->generatePoll()[0];
        $this->pollService->delete($poll->id);
        $this->assertFalse(Polls::findFirst($poll->id));
    }

    public function testGet()
    {
        list($poll, $title, $items) = $this->generatePoll();
        $i = 0;
        foreach ($this->pollService->get($poll->id)->getItems() as $item) {
            $this->assertEquals($items[$i++], $item->text);
        }
    }

    public function testVote()
    {
        $poll = $this->generatePoll()[0];
        $poll_item_id1 = $poll->items[0]->id;
        $poll_item_id2 = $poll->items[1]->id;
        
        //Same IP multiple Votes
        $ip = $this->faker->ipv4;
        $this->assertEquals(1, $this->pollService->vote($poll_item_id1, $ip));
        $this->assertFalse($this->pollService->vote($poll_item_id1, $ip));
        $this->assertFalse($this->pollService->vote($poll_item_id2, $ip));
        
        //Another IP
        $ip = $this->faker->ipv4;
        $this->assertEquals(2, $this->pollService->vote($poll_item_id1, $ip));
        $this->assertFalse($this->pollService->vote($poll_item_id1, $ip));
        $this->assertFalse($this->pollService->vote($poll_item_id2, $ip));
        
        //Test afterDelete
        $poll_id = $poll->id;
        $poll->delete();
        $this->assertFalse((new PollLogs($poll_id))->exists());
        $this->assertFalse((new PollItemsCount($poll_id))->exists());
    }
}
