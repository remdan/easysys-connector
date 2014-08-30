<?php

namespace EasysysConnector\HttpAdapter;

class HttpParameterBag
{
    /**
     * @var string
     */
    protected $baseUrl = 'https://office.easysys.ch/api2.php';

    /**
     * @var string
     */
    protected $uri = '';

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $accept = 'application/json';

    /**
     * @var array
     */
    protected $headers = array();

    /**
     * @var array
     */
    protected $parameterGet = array();

    /**
     * @var array
     */
    protected $parameterPost = array();

    /**
     * @var null
     */
    protected $parameterPostFormat = null;

    /**
     * @return array
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param null $method
     * @return $this
     */
    public function setMethod($method = null)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * @param null $accept
     * @return $this
     */
    public function setAccept($accept = null)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders($headers = array())
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param array $header
     * @return $this
     */
    public function setHeader($header = array())
    {
        $headers = $this->getHeaders();
        $headers = array_merge($headers, $header);

        return $this;
    }

    /**
     * @return array
     */
    public function getParameterGet()
    {
        return $this->parameterGet;
    }

    /**
     * @param array $parameterGet
     * @return $this
     */
    public function setParameterGet($parameterGet = array())
    {
        $this->parameterGet = $parameterGet;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameterPost()
    {
        return $this->parameterPost;
    }

    /**
     * @param array $parameterPost
     * @return $this
     */
    public function setParameterPost($parameterPost = array())
    {
        $this->parameterPost = $parameterPost;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParameterPostFormat()
    {
        return $this->parameterPostFormat;
    }

    /**
     * @param null $parameterPostFormat
     * @return $this
     */
    public function setParameterPostFormat($parameterPostFormat = null)
    {
        $this->parameterPostFormat = $parameterPostFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param null $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl = null)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param null $uri
     * @return $this
     */
    public function setUri($uri = null)
    {
        $this->uri = $uri;

        return $this;
    }
}