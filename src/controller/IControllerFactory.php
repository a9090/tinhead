<?php


namespace tinhead\controller;


interface IControllerFactory
{
    public function createGetController(string $controllerName):IGetController;

    public function createPostController(string $controllerName):IPostController;

    public function createPutController(string $controllerName):IPutController;

    public function createDeleteController(string $controllerName):IDeleteController;
}