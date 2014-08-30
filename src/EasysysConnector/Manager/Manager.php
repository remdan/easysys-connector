<?php

namespace EasysysConnector\Manager;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;
use EasysysConnector\HttpAdapter\HttpRequest;
use EasysysConnector\HttpAdapter\HttpResponse;
use EasysysConnector\Manager\ManagerInterface;
use EasysysConnector\OutputHandler\OutputHandlerInterface;

class Manager implements ManagerInterface
{
    /**
     * @var HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     * @var AuthAdapterInterface
     */
    protected $authAdapter;

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @param AuthAdapterInterface $authAdapter
     */
    public function __construct(
        HttpAdapterInterface $httpAdapter = null,
        AuthAdapterInterface $authAdapter = null
    )
    {
        $this->httpAdapter = $httpAdapter;
        $this->authAdapter = $authAdapter;
    }

    /**
     * @return HttpAdapterInterface
     * @throws \Exception
     */
    public function getHttpAdapter()
    {
        if (is_null($this->httpAdapter)) {
            throw new \Exception('Please define a httpAdapter based on the HttpAdapterInterface!');
        }

        return $this->httpAdapter;
    }

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @return $this
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;

        return $this;
    }

    /**
     * @return AuthAdapterInterface
     * @throws \Exception
     */
    public function getAuthAdapter()
    {
        if (is_null($this->authAdapter)) {
            throw new \Exception('Please define a authAdapter based on the AuthAdapterInterface!');
        }

        return $this->authAdapter;
    }

    /**
     * @param AuthAdapterInterface $authAdapter
     * @return $this
     */
    public function setAuthAdapter(AuthAdapterInterface $authAdapter)
    {
        $this->authAdapter = $authAdapter;

        return $this;
    }

    /**
     * @param HttpResponse $response
     * @throws \Exception
     */
    public function checkResponse(HttpResponse $response)
    {
        if ($response->hasHeader(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE) && $response->getHeader(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE) == 'application/json') {
            $content = $response->getContent();
            $content = json_decode($content, true);

            if (is_array($content) && array_key_exists('error', $content)) {
                throw new \Exception($response->getStatusCode() . ' - ' . $content['error'] . ': ' . $content['error_description']);
            }

            if (is_array($content) && array_key_exists('error_code', $content)) {
                $message = $response->getStatusCode() . ' - ' . $content['error_code'] . ': ' . $content['message'];
                if (array_key_exists('errors', $content)) {
                    $message = $message . implode($content['errors']);
                }
                throw new \Exception($message);
            }
        }
        if ($response->getStatusCode() != 200) {
            //TODO: Handling for other status code
        }
    }

    /**
     * @param HttpResponse $response
     * @param OutputHandlerInterface $outputHandler
     * @return HttpResponse|mixed
     */
    public function handleResponse(HttpResponse $response, OutputHandlerInterface $outputHandler = null)
    {
        if ($outputHandler) {
            $response = $outputHandler->getContent($response->getContent());
        }

        return $response;
    }

    /**
     * @param HttpParameterBag $parameterBag
     * @param OutputHandlerInterface $outputHandler
     * @return HttpResponse
     */
    public function execute(HttpParameterBag $parameterBag, OutputHandlerInterface $outputHandler = null)
    {
        $content = '';
        if ($parameterBag->getParameterPostFormat() == 'application/json') {
            $content = json_encode($parameterBag->getParameterPost());
        }

        $request = new HttpRequest($parameterBag->getMethod(), $this->getUrl($parameterBag), $parameterBag->getHeaders(), $content);

        $response = $this->getHttpAdapter()->handleRequest($request);

        $this->checkResponse($response);

        return $this->handleResponse($response, $outputHandler);
    }

    /**
     * @param HttpParameterBag $parameterBag
     * @return string
     */
    public function getUrl(HttpParameterBag $parameterBag)
    {
        $parameters = '';
        $parametersGet = $parameterBag->getParameterGet();
        if (!empty($parametersGet)) {
            $parameters = (string)'?' . http_build_query($parameterBag->getParameterGet());
        }

        return (string)$this->getAuthAdapter()->getRequestUrl($parameterBag) . '' . $parameters;
    }

    /**
     * @param $resourceMethod
     * @param array $parameters
     * @return string
     * @throws \Exception
     */
    public function getRequestUri($resourceMethod, array $parameters = array())
    {
        $requestUriPattern = $this->getRequestUriPattern($resourceMethod);

        var_dump($requestUriPattern);

        $requestUri = (string)vsprintf($requestUriPattern, $parameters);

        var_dump($requestUri);

        return $requestUri;
    }

    /**
     * @param $method
     * @param $resourceMethod
     * @param array $requestUriParameters
     * @param array $parametersGet
     * @param array $parametersPost
     * @return HttpParameterBag
     * @throws \Exception
     */
    public function createParameterBag($method, $resourceMethod, $requestUriParameters = array(), $parametersGet = array(), $parametersPost = array())
    {
        $parameterBag = new HttpParameterBag();

        $parameterBag->setMethod($method);
        $parameterBag->setParameterGet($parametersGet);

        $parameterBag->setUri($this->getRequestUri($resourceMethod, $requestUriParameters));

        if ($method == HttpAdapterInterface::HTTP_METHOD_POST || $method == HttpAdapterInterface::HTTP_METHOD_PUT) {
            $parameterBag->setParameterPostFormat('application/json');
            $parameterBag->setParameterPost($parametersPost);
        }

        $parameterBag->setHeaders($this->getAuthAdapter()->getDefaultHeaders($parameterBag));

        return $parameterBag;
    }

    /**
     * @param string $method
     * @return string
     */
    public static function getRequestUriPattern($method)
    {
        return '%s';
    }
}