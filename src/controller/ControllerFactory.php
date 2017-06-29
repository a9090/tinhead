<?php

namespace tinhead\controller;

use tinhead\error\MethodNotAllowedException;
use tinhead\error\NotFoundException;

class ControllerFactory implements IControllerFactory
{

    /**
     * Contains all controllers to be instantiated by the factory. Set this array by a configuration file.
     * @var array<IController>
     */
    private $map = array();

    /**
     * ControllerFactory constructor.
     *
     * @param array $controllerMap Map of IController classes to be instantiated by the factory.
     *              The map must be of the following form:
     *              array( "unique name" => IController::class)
     */
    public function __construct(array $controllerMap)
    {
        $this->map = $controllerMap;
    }

    /**
     * Returns a IGetController instance, according to given controller name.
     * If no controller with this name is registered, a NotFoundException is thrown.
     * If a controller with this name exists, but does not implement the IGetController interface,
     * an MethodNotAllowedException is thrown.
     *
     * @param String
     * @return IGetController
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
	public function createGetController(string $controllerName):IGetController
	{
        $this->checkIfControllerExists($controllerName);
        $this->checkIfControllerImplementsInterface($controllerName, "\\tinhead\\controller\\IGetController");

		return new $this->map[$controllerName]();
	}

    /**
     * Returns a IPostController instance, according to given controller name.
     * If no controller with this name is registered, a NotFoundException is thrown.
     * If a controller with this name exists, but does not implement the IGetController interface,
     * an MethodNotAllowedException is thrown.
     *
     * @param String
     * @return IPostController
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function createPostController(string $controllerName):IPostController
    {
        $this->checkIfControllerExists($controllerName);
        $this->checkIfControllerImplementsInterface($controllerName, "\\tinhead\\controller\\IPostController");

		return new $this->map[$controllerName]();
    }


    /**
     * Returns a IPutController instance, according to given controller name.
     * If no controller with this name is registered, a NotFoundException is thrown.
     * If a controller with this name exists, but does not implement the IGetController interface,
     * an MethodNotAllowedException is thrown.
     *
     * @param String
     * @return IPutController
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function createPutController(string $controllerName):IPutController
    {
        $this->checkIfControllerExists($controllerName);
        $this->checkIfControllerImplementsInterface($controllerName, "\\tinhead\\controller\\IPutController");

		return new $this->map[$controllerName]();
    }

    /**
     * Returns a IPutController instance, according to given controller name.
     * If no controller with this name is registered, a NotFoundException is thrown.
     * If a controller with this name exists, but does not implement the IGetController interface,
     * an MethodNotAllowedException is thrown.
     *
     * @param String
     * @return IDeleteController
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function createDeleteController(string $controllerName): IDeleteController
    {
        $this->checkIfControllerExists($controllerName);
        $this->checkIfControllerImplementsInterface($controllerName, "\\tinhead\\controller\\IDeleteController");

        return new $this->map[$controllerName]();
    }

    /**
     * Checks if a controller with the given name is registered. If not, an NotFoundException is thrown.
     *
     * @param string $controllerName
     * @throws NotFoundException
     */
    private function checkIfControllerExists(string $controllerName):void {

        if (array_key_exists($controllerName, $this->map) == false) {
            throw new NotFoundException();
        }

    }

    /**
     * Checks if a controller with the given name does implement the given interface.
     * If not, an MethodNotAllowedException is thrown.
     *
     * @param string $controllerName
     * @param string $interfaceName
     * @throws MethodNotAllowedException
     */
    private function checkIfControllerImplementsInterface(string $controllerName, string $interfaceName) {

        if (is_subclass_of($this->map[$controllerName], $interfaceName) == false) {
            throw new MethodNotAllowedException();
        }
    }


}

