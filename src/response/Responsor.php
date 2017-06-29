<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 16:21
 */

namespace tinhead\response;


use tinhead\HttpStatus;

class Responsor implements IResponseSender
{

    /**
     * Sends the given content to the client with an HTTP 200 (ok) status.
     * If the given content is empty, only HTTP 204 (no content) will be sent.
     *
     * @param string $content
     */
    public function sendResponse(string $content): void
    {
        if ($content != "") {
            $this->sendResponseWithContent($content);
        } else {
            $this->sendEmptyResponse();
        }
    }


    private function sendResponseWithContent(string $content):void {

        http_response_code(HttpStatus::OK);
        header("Content-Type: application/json; charset=utf-8");

        print $content;
    }

    private function sendEmptyResponse():void {
        http_response_code(HttpStatus::NO_CONTENT);
    }

}