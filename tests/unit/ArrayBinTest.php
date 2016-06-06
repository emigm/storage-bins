<?php

namespace StorageBins;

use PHPUnit_Framework_TestCase;

class ArrayBinTest extends PHPUnit_Framework_TestCase
{
    private $snake_case_array;
    private $camel_case_array;

    public function setUp()
    {
        $this->camel_case_array = [
            'key'   => 'val',
            'key1' => 'val1',
            'keyA' => 'valA',
        ];

        $this->snake_case_array = [
            'key'   => 'val',
            'key_1' => 'val_1',
            'key_a' => 'val_a',
        ];
    }

    public function testCreateArrayBinSuccessfully()
    {
        $bin = new ArrayBin([]);

        $this->assertTrue($bin instanceof ArrayBin);
    }

    public function testGetCamelCaseArrayAttributesSuccessfully()
    {
        $bin = new ArrayBin($this->camel_case_array);

        $this->assertEquals($this->camel_case_array['key'], $bin->getKey());
        $this->assertEquals($this->camel_case_array['key1'], $bin->getKey1());
        $this->assertEquals($this->camel_case_array['keyA'], $bin->getKeyA());
    }

    public function testGetSnakeCaseArrayAttributesSuccessfully()
    {
        $bin = new ArrayBin($this->snake_case_array, false);

        $this->assertEquals($this->snake_case_array['key'], $bin->getKey());
        $this->assertEquals($this->snake_case_array['key_1'], $bin->getKey1());
        $this->assertEquals($this->snake_case_array['key_a'], $bin->getKeyA());
    }
}
