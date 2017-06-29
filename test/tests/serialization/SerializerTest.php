<?php

namespace tinhead\test\serialization;


use tinhead\serialization\DtoSerializer;

use tinhead\test\testutils\EmptyDto;
use tinhead\test\testutils\NonDto;
use tinhead\test\testutils\SimpleDto;

use PHPUnit\Framework\TestCase;

class SerializerTest extends TestCase
{

    /**
     * System under test
     * @var DtoSerializer
     */
    private $serializer = null;

    /**
     * @before
     */
    public function setup() {
        $this->serializer = new DtoSerializer();
    }


    /**
     * @test
     */
    public function serializeToArray_EmptyDto():void {

        $dto = new EmptyDto();

        $resultArray = $this->serializer->serializeToArray($dto);

        $this->assertNotNull($resultArray);
        $this->assertInternalType('array', $resultArray);
        $this->assertEquals(0, sizeof($resultArray));
    }


    /**
     * @test
     */
    public function serializeToArray_DtoWithBasicTypes():void {
        $dto = new SimpleDto();
        $dto->a = "Hello world";
        $dto->b = 3;
        $dto->c = 9.9;
        $dto->d = true;
        $dto->e = null;

        $expectedArray = array(
            'a' => "Hello world",
            'b' => 3,
            'c' => 9.9,
            'd' => true,
            'e' => null
        );

        $resultArray = $this->serializer->serializeToArray($dto);

        $this->assertNotNull($resultArray);
        $this->assertInternalType('array', $resultArray);
        $this->assertEquals($expectedArray, $resultArray);
    }

    /**
     * @test
     */
    public function serializeToArray_DtoWithUnsupportedTypes():void {

        $nonDto1 = new NonDto();
        $nonDto1->x = "some text, not to be serialized";

        $nonDto2 = new NonDto();


        $dto = new SimpleDto();
        $dto->a = "abc";
        $dto->b = null;
        $dto->c = $nonDto1;
        $dto->d = false;
        $dto->e = $nonDto2;

        $expectedArray = array(
            'a' => "abc",
            'b' => null,
            'd' => false,
        );

        $resultArray = $this->serializer->serializeToArray($dto);

        $this->assertNotNull($resultArray);
        $this->assertInternalType('array', $resultArray);
        $this->assertEquals($expectedArray, $resultArray);

    }

    /**
     * @test
     */
    public function serializeToArray_DtoWithArray():void {

        $dto = new SimpleDto();
        $dto->a = array(3, 9, 99);
        $dto->b = array('aa' => 'Hello World', 'bb' => 3, 'cc' => null);

        $expectedArray = array(
            'a' => array(3, 9, 99),
            'b' => array('aa' => 'Hello World', 'bb' => 3, 'cc' => null),
            'c' => null,
            'd' => null,
            'e' => null
        );

        $resultArray = $this->serializer->serializeToArray($dto);

        $this->assertNotNull($resultArray);
        $this->assertInternalType('array', $resultArray);
        $this->assertEquals($expectedArray, $resultArray);
    }

    /**
     * @test
     */
    public function serializeToArray_NestedDto():void {

        $innerDto = new SimpleDto();
        $innerDto->a = "inner hello";
        $innerDto->b = 3;

        $dto = new SimpleDto();
        $dto->a = "outer hello";
        $dto->b = $innerDto;
        $dto->c = 98771.1;

        $expectedArray = array(
            'a' => "outer hello",
            'b' => array('a' => 'inner hello', 'b' => 3, 'c' => null, 'd' => null, 'e' => null),
            'c' => 98771.1,
            'd' => null,
            'e' => null
        );

        $resultArray = $this->serializer->serializeToArray($dto);

        $this->assertNotNull($resultArray);
        $this->assertInternalType('array', $resultArray);
        $this->assertEquals($expectedArray, $resultArray);
    }

    /**
     * @test
     */
    public function serializeToString_NestedDto():void {

        $innerDto = new SimpleDto();
        $innerDto->a = "inner hello";
        $innerDto->b = true;
        $innerDto->e = 99;

        $dto = new SimpleDto();
        $dto->a = "outer hello";
        $dto->b = $innerDto;
        $dto->c = 98771.1;

        $expectedArray = array(
            'a' => "outer hello",
            'b' => array('a' => 'inner hello', 'b' => true, 'c' => null, 'd' => null, 'e' => 99),
            'c' => 98771.1,
            'd' => null,
            'e' => null
        );

        // Serialize to DTO string
        $resultJson = $this->serializer->serialize($dto);

        $this->assertNotNull($resultJson);
        $this->assertInternalType('string', $resultJson);

        // De-serialize the DTO string into an array, to compare values
        $resultArrayDecoded = \json_decode($resultJson, true);

        $this->assertEquals($expectedArray, $resultArrayDecoded);

    }

}
