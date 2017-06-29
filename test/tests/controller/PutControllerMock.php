<?php

namespace tinhead\test\tests\controller;


use tinhead\controller\IPutController;
use tinhead\serialization\ISerializable;
use tinhead\test\testutils\SimpleDto;

class PutControllerMock implements IPutController
{

    const ENDPOINT = "PutControllerMock";

    public function putRequest(array $endpointParts): ISerializable
    {
        $dto = new SimpleDto();
        $dto->a = "Created from PutControllerMock";

        return $dto;
    }

}