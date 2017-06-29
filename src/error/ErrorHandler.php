<?php

namespace tinhead\error;


use tinhead\HttpStatus;

class ErrorHandler implements IErrorHandler
{
    private $httpStatus = HttpStatus::INTERNAL_SERVER_ERROR;
    private $responseMessage = "";

    /**
     * Sends HTTP 404 (not found) to client, when go() is called.
     *
     * @param NotFoundException $e
     */
    public function sendNotFound(NotFoundException $e):void {
        $this->httpStatus = HttpStatus::NOT_FOUND;
        $this->setResponseMessage($e->getMessage());
        $this->sendResponse();
    }

    /**
     * Sends HTTP 405 (method not allowed) to client, when go() is called.
     *
     * @param MethodNotAllowedException $e
     */
    public function sendMethodNotAllowed(MethodNotAllowedException $e):void {
        $this->httpStatus = HttpStatus::METHOD_NOT_ALLOWED;
        $this->setResponseMessage($e->getMessage());
        $this->sendResponse();
    }

    /**
     * Sends HTTP 500 (internal server error) to client, when go() is called.
     *
     * @param \Exception $e
     */
    public function sendInternalServerError(\Exception $e):void {
        $this->httpStatus = HttpStatus::INTERNAL_SERVER_ERROR;
        $this->setResponseMessage($e->getMessage());
        $this->sendResponse();
    }

    /**
     * Sets the message to be sent to the client.
     *
     * @param String $message
     */
    private function setResponseMessage(String $message):void {
        $this->responseMessage = $message;
    }

    /**
     * Sends the status code and error message to the client.
     *
     * @return void
     */
    private function sendResponse():void
    {
        http_response_code($this->httpStatus);

        print $this->responseMessage;
    }

}

