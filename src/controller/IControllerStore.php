<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.06.17
 * Time: 21:01
 */

namespace tinhead\controller;


interface IControllerStore
{
    /**
     * Registers the given controller to be created by the ControllerFactory on Request
     *
     * @param IController $controller
     */
    public function add(IController $controller):void;
}