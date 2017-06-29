<?php

namespace tinhead\test\tests\controller;

use tinhead\controller\ControllerFactory;
use tinhead\error\MethodNotAllowedException;
use tinhead\error\NotFoundException;

use PHPUnit\Framework\TestCase;


class ControllerFactoryTest extends TestCase
{

    private $controllerFactory = null;

    /**
     * @before
     */
    public function setup():void {

        $controllerMap = array(
            GetControllerMock::ENDPOINT => GetControllerMock::class,
            PostControllerMock::ENDPOINT => PostControllerMock::class,
            PutControllerMock::ENDPOINT => PutControllerMock::class,
            DeleteControllerMock::ENDPOINT => DeleteControllerMock::class
        );

        $this->controllerFactory = new ControllerFactory($controllerMap);
    }

    /**
     * Tests crateGetController - GET
     *
     * @test
     */
    public function createGetController():void {

        $controller = $this->controllerFactory->createGetController(GetControllerMock::ENDPOINT);
        $this->assertNotNull($controller);

        $dtoFromController = $controller->getRequest(array());
        $this->assertNotNull($dtoFromController);
        $this->assertEquals("Created from GetControllerMock", $dtoFromController->a);

    }

    /**
     * Tests crateGetController - GET
     *
     * @test
     */
    public function notFoundExceptionInCrateGetController():void {

        $this->expectException(NotFoundException::class);
        $this->controllerFactory->createGetController("InvalidControllerName");

    }

    /**
     * Tests crateGetController - GET
     *
     * @test
     */
    public function methodNotAllowedExceptionInCrateGetController():void {

        $this->expectException(MethodNotAllowedException::class);
        $this->controllerFactory->createGetController(PostControllerMock::ENDPOINT);

    }

    /**
     * Tests cratePostController - POST
     *
     * @test
     */
    public function createPostController():void {

        $controller = $this->controllerFactory->createPostController(PostControllerMock::ENDPOINT);
        $this->assertNotNull($controller);

        $dtoFromController = $controller->postRequest(array());
        $this->assertNotNull($dtoFromController);
        $this->assertEquals("Created from PostControllerMock", $dtoFromController->a);

    }

    /**
     * Tests cratePostController - POST
     *
     * @test
     */
    public function notFoundExceptionInCratePostController():void {

        $this->expectException(NotFoundException::class);
        $this->controllerFactory->createPostController("InvalidControllerName");

    }

    /**
     * Tests cratePostController - POST
     *
     * @test
     */
    public function methodNotAllowedExceptionInCratePostController():void {

        $this->expectException(MethodNotAllowedException::class);
        $this->controllerFactory->createPostController(PutControllerMock::ENDPOINT);

    }


    /**
     * Tests cratePutController - PUT
     *
     * @test
     */
    public function createPutController():void {

        $controller = $this->controllerFactory->createPutController(PutControllerMock::ENDPOINT);
        $this->assertNotNull($controller);

        $dtoFromController = $controller->putRequest(array());
        $this->assertNotNull($dtoFromController);
        $this->assertEquals("Created from PutControllerMock", $dtoFromController->a);

    }

    /**
     * Tests cratePutController - PUT
     *
     * @test
     */
    public function notFoundExceptionInCratePutController():void {

        $this->expectException(NotFoundException::class);
        $this->controllerFactory->createPutController("InvalidControllerName");

    }

    /**
     * Tests cratePutController - PUT
     *
     * @test
     */
    public function methodNotAllowedExceptionInCratePutController():void {

        $this->expectException(MethodNotAllowedException::class);
        $this->controllerFactory->createPutController(GetControllerMock::ENDPOINT);

    }

    /**
     * Tests crateDeleteController - DELETE
     *
     * @test
     */
    public function createDeleteController():void {

        $controller = $this->controllerFactory->createDeleteController(DeleteControllerMock::ENDPOINT);
        $this->assertNotNull($controller);

        $dtoFromController = $controller->deleteRequest(array());
        $this->assertNotNull($dtoFromController);
        $this->assertEquals("Created from DeleteControllerMock", $dtoFromController->a);

    }

    /**
     * Tests crateDeleteController - DELETE
     *
     * @test
     */
    public function notFoundExceptionInCrateDeleteController():void {

        $this->expectException(NotFoundException::class);
        $this->controllerFactory->createDeleteController("InvalidControllerName");

    }

    /**
     * Tests crateDeleteController - DELETE
     *
     * @test
     */
    public function methodNotAllowedExceptionInCrateDeleteController():void {

        $this->expectException(MethodNotAllowedException::class);
        $this->controllerFactory->createDeleteController(GetControllerMock::ENDPOINT);

    }
}
