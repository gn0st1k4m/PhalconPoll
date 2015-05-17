<?php

namespace PhalconPoll\Tests;

/**
 * @author Peter Chung <touhonoob@gmail.com>
 * @date May 16, 2015
 */
abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Faker\Generator
     */
    protected $faker;
    
    public function setUp() {
        $this->faker = (new \Faker\Factory)->create();
    }
}
