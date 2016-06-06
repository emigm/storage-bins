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
            'keyArr' => [1, 2, 3, ],
        ];

        $this->snake_case_array = [
            'key'   => 'val',
            'key_1' => 'val_1',
            'key_a' => 'val_a',
            'key_arr' => [1, 2, 3, ],
        ];

        $this->nested_array = [
            'key_a' => [
                'key_b' => [
                    'key_c' => 'value',
                ],
            ],
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
        $this->assertEquals($this->camel_case_array['keyArr'], $bin->getKeyArr());
    }

    public function testGetSnakeCaseArrayAttributesSuccessfully()
    {
        $bin = new ArrayBin($this->snake_case_array, false);

        $this->assertEquals($this->snake_case_array['key'], $bin->getKey());
        $this->assertEquals($this->snake_case_array['key_1'], $bin->getKey1());
        $this->assertEquals($this->snake_case_array['key_a'], $bin->getKeyA());
        $this->assertEquals($this->snake_case_array['key_arr'], $bin->getKeyArr());
    }

    public function testGetNestedArrayAttributeSuccessfully()
    {
        $bin = new ArrayBin($this->nested_array, false);

        $this->assertEquals(
            $this->nested_array['key_a']['key_b']['key_c'],
            $bin->getKeyA()->getKeyB()->getKeyC()
        );
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testGetUndefinedArrayAttributeRaiseBadMethodCallException()
    {
        $bin = new ArrayBin($this->snake_case_array, false);

        $bin->getUndefined();
    }
}
