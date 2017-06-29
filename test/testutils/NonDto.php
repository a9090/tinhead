<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 16:11
 */

namespace tinhead\test\testutils;

/**
 * Class NonDto
 *
 * Does not implement the ISerializable interface, thus the DtoSerializer may not not use
 * any of it's attributes for serialization.
 *
 * @package tinhead\test\\serialization
 */
class NonDto
{
    public $x = null;
    public $y = null;
    public $z = null;
}