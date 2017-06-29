<?php

namespace tinhead\test\tests\controller;


use tinhead\controller\IGetController;
use tinhead\serialization\ISerializable;
use tinhead\test\testutils\SimpleDto;


class GetControllerMock implements IGetController
{

    const ENDPOINT = "MyGetControllerMock";

    public function getRequest(array $endpointParts): ISerializable
    {
        $dto = new SimpleDto();
        $dto->a = "Created from GetControllerMock";

        return $dto;
    }
}