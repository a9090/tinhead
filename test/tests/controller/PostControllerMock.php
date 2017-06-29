<?php

namespace tinhead\test\tests\controller;


use tinhead\controller\IPostController;
use tinhead\serialization\ISerializable;
use tinhead\test\testutils\SimpleDto;

class PostControllerMock implements IPostController
{

    const ENDPOINT = "PostControllerMock";

    public function postRequest(array $endpointParts): ISerializable
    {
        $dto = new SimpleDto();
        $dto->a = "Created from PostControllerMock";

        return $dto;
    }

}