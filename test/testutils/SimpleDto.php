<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 15:22
 */

namespace tinhead\test\testutils;


use tinhead\serialization\ISerializable;

class SimpleDto implements ISerializable
{
    public $a = null;
    public $b = null;
    public $c = null;
    public $d = null;
    public $e = null;
}