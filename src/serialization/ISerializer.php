<?php

namespace tinhead\serialization;


interface ISerializer
{
    public function serialize(ISerializable $dto):string;
}