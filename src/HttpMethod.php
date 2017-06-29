<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 09:08
 */

namespace tinhead;


abstract class HttpMethod
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const HEAD = "HEAD";
    const DELETE = "DELETE";
    const OPTIONS = "OPTIONS";
    const TRACE = "TRACE";
    const CONNECT = "CONNECT";

}