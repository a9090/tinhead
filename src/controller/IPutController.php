<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.06.17
 * Time: 19:48
 */

namespace tinhead\controller;

use tinhead\serialization\ISerializable;

interface IPutController extends IController
{

    /**
     * Starts the controller actions for an GET request.
     *
     * @param array $endpointParts contains all sub parts of the requested endpoint.
     *        Example: On API call /a/b/c the value "a" is used to identify the controller,
     *        values "b" and "c" will be given to the controller in the $endpointParts array.
     * @return ISerializable DTO for response to client.
     */
    public function putRequest(array $endpointParts):ISerializable;



}