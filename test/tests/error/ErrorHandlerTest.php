<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.06.17
 * Time: 16:40
 */

namespace tinhead\test\error;

use tinhead\error\ErrorHandler;
use PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function send404():void {

        $this->fail();

    }

}
