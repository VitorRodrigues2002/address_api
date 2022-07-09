<?php

class SerializePathTest extends TestCase
{
    public function testSerializePath()
    {
        $path = 'tests\Unit/SerializePathTest/concelhos.txt';

        $this->assertTrue((serializePath($path) === 'tests\Unit\SerializePathTest\concelhos.txt'));

        $this->assertStringNotContainsString('/', serializePath($path));
    }
}
