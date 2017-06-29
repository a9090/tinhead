<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 16:21
 */

namespace tinhead\response;


interface IResponseSender
{
    /**
     * Sends the given content back to the client.
     *
     * @param string $content
     */
    public function sendResponse(string $content):void;
}