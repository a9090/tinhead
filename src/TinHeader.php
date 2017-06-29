<?php

namespace tinhead;


use tinhead\controller\ControllerFactory;
use tinhead\controller\IControllerFactory;
use tinhead\error\ErrorHandler;
use tinhead\error\IErrorHandler;
use tinhead\error\MethodNotAllowedException;
use tinhead\error\NotFoundException;
use tinhead\response\IResponseSender;
use tinhead\response\Responsor;
use tinhead\serialization\DtoSerializer;
use tinhead\serialization\ISerializer;
use tinhead\serialization\ISerializable;

class TinHeader
{

    /**
     * @var IControllerFactory
     */
    private $controllerFactory = null;

    /**
     * @var IErrorHandler
     */
    private $errorHandler = null;

    /**
     * @var ISerializer
     */
    private $responseSerializer = null;

    /**
     * @var IResponseSender
     */
    private $responsor = null;

    /**
     * Inits the library. The given array has to contain all controller classes as a map of the form (endpoint => class)
     *
     * The endpoint is a string and unique in the map. It identifies the endpoint for which the controller is responsible.
     * A controller's endpoint should be named in a static class member ENDPOINT. Following this recommendation you
     * may use the following syntax when configure the map:
     *
     * array(MyController::ENDPOINT => MyController::class, ...)
     *
     * Note: Each class named in the map must implement at least one of the tinhead controller Interfaces of package
     * 'controller'.
     *
     * @param array $controllerCollection Map (Endpoint (string) => Controller (class))
     * @return TinHeader instance to start the application.
     */
    public static function init(array $controllerCollection) {

        $controllerFactory = new ControllerFactory($controllerCollection);
        $errorHandler = new ErrorHandler();
        $responsor = new Responsor();
        $dtoSerializer = new DtoSerializer();

        return new TinHeader($controllerFactory, $dtoSerializer, $responsor, $errorHandler);
    }

    /**
     * App constructor.
     *
     * @param IControllerFactory $controllerFactory
     * @param ISerializer $serializer
     * @param IResponseSender $responsor
     * @param IErrorHandler $errorHandler
     */
    public function __construct(IControllerFactory $controllerFactory, ISerializer $serializer,
                                IResponseSender $responsor, IErrorHandler $errorHandler)
    {
        $this->controllerFactory = $controllerFactory;
        $this->errorHandler = $errorHandler;
        $this->responsor = $responsor;
        $this->responseSerializer = $serializer;

        // Register the final shutdown function
        register_shutdown_function([$this, "shutdown"]);
    }

    /**
	 * Main function to start application execution.
	 *
     * @param array $endpointParts contains the parts of the called endpoint.
     *        Example: On API call with /a/b/c the array contains the three items "a", "b" and "c"
	 * @return void
	 */
	public function start(array $endpointParts):void {

		try {
            // Fetch the first item in the endpointParts array and remove it.
            // The first item is used to identify the controller to handle the request.
            // All other items will be forwarded to the controller.
            $requestedControllerName = array_shift($endpointParts);

            // Fetch HTTP method from request
            $requestedHttpMethod = $_SERVER['REQUEST_METHOD'];

            $responseDto = $this->runController($requestedHttpMethod, $requestedControllerName, $endpointParts);
            $this->sendResponse($responseDto);

        } catch (NotFoundException $e) {
            $this->errorHandler->sendNotFound($e);
        } catch (MethodNotAllowedException $e) {
            $this->errorHandler->sendMethodNotAllowed($e);
        } catch (\Exception $e) {
            $this->errorHandler->sendInternalServerError($e);
        }
	}

    /**
     * Tries to find the controller with the given name and to run it for the given HTTP method.
     * If no such controller exists an NotFoundException is thrown.
     * If the controller does not implement the given HTTP method an MethodNotAllowedException is thrown.
     *
     * @param string $httpMethod
     * @param string $controllerName
     * @param array $endpointParts
     * @return ISerializable Result of controller execution to be sent to the client
     * @throws MethodNotAllowedException
     */
	private function runController(string $httpMethod, string $controllerName, array $endpointParts):ISerializable {

        switch($httpMethod) {
            case HttpMethod::GET:
                $controller = $this->controllerFactory->createGetController($controllerName);
                $responseDto = $controller->getRequest($endpointParts);
                break;
            case HttpMethod::POST:
                $controller = $this->controllerFactory->createPostController($controllerName);
                $responseDto = $controller->postRequest($endpointParts);
                break;
            case HttpMethod::PUT:
                $controller = $this->controllerFactory->createPutController($controllerName);
                $responseDto = $controller->putRequest($endpointParts);
                break;
            case HttpMethod::DELETE:
                $controller = $this->controllerFactory->createDeleteController($controllerName);
                $responseDto = $controller->deleteRequest($endpointParts);
                break;
            default:
                throw new MethodNotAllowedException();
        }

        return $responseDto;
    }

    /**
     * Converts the given DTO into a string and sends it as response to the client.
     *
     * @param ISerializable $dto
     */
    private function sendResponse(ISerializable $dto):void {
	    $responseContent = $this->responseSerializer->serialize($dto);
        $this->responsor->sendResponse($responseContent);
    }

    /**
     * Function is called before the script execution terminates.
     * If a fatal error occurred during the application run, the error handler is called.
     *
     * @return void
     */
    public function shutdown():void {

        $lastError = error_get_last();
        if ($lastError['type'] === E_ERROR) {
            $e = new \Exception($lastError['message'], $lastError['type']);
            $this->errorHandler->sendInternalServerError($e);
        }
    }

}

