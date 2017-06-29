<?php

namespace tinhead\test\tests\controller;


use tinhead\controller\IDeleteController;
use tinhead\serialization\ISerializable;
use tinhead\test\testutils\SimpleDto;

class DeleteControllerMock implements IDeleteController
{

    const ENDPOINT = "DeleteControllerMock";

    public function deleteRequest(array $endpointParts):ISerializable
    {
        $dto = new SimpleDto();
        $dto->a = "Created from DeleteControllerMock";

        return $dto;
    }

}