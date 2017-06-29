<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.06.17
 * Time: 21:00
 */

namespace tinhead\controller;


class ControllerStore implements IControllerStore
{

    private $map = array();

    public function add(IController $controller): void
    {
        $map[$controller::getName()] = $controller::getClass();
    }

    public function getControllerClassByName(string $name):IController
    {
        return $this->map[$name];
    }

}