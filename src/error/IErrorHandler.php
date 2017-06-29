<?php

namespace tinhead\error;


interface IErrorHandler
{

    public function sendNotFound(NotFoundException $e):void;

    public function sendMethodNotAllowed(MethodNotAllowedException $e):void;

    public function sendInternalServerError(\Exception $e):void;

}