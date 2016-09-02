<?php

use hexpang\google\Search;

class InstanceTestCase extends \PHPUnit_Framework_TestCase
{
    public function instanceTest()
    {
        $search = new Search();
        $this->assertInstanceOf("hexpang\google\Search", $search);
    }
}
