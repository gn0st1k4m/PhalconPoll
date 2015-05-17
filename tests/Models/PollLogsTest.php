<?php

namespace PhalconPoll\Tests\Poll\Models;

use PhalconPoll\Models\PollLogs;
use Mykomica\Common\Lib;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date May 15, 2015
 */
class PollLogsTest extends \PHPUnit_Framework_TestCase
{
    const POLL_ID = 1;
    
    private $faker;
    private $pollLog;

    public function setUp()
    {
        $this->faker = (new \Faker\Factory)->create();
        $this->pollLog = new PollLogs(self::POLL_ID);
    }

    public function tearDown()
    {
        $this->pollLog->del();
    }

    public function testAdd()
    {
        //Add Same IP Twice
        $ip_hex = \PhalconPoll\ip2hex($this->faker->ipv4);
        $this->assertTrue($this->pollLog->add($ip_hex));
        $this->assertFalse($this->pollLog->add($ip_hex));
        
        //Add Another IP
        $ip_hex = \PhalconPoll\ip2hex($this->faker->ipv4);
        $this->assertTrue($this->pollLog->add($ip_hex));
        
        //Count
        $this->assertEquals(2, $this->pollLog->count());
    }
}
