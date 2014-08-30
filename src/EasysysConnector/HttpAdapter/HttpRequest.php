<?php

namespace EasysysConnector\HttpAdapter;

use EasysysConnector\HttpAdapter\HttpMessage;

class HttpRequest extends HttpMessage
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param array $method
     * @param $url
     * @param array $headers
     * @param $content
     */
    public function __construct($method, $url, array $headers, $content)
    {
        parent::__construct($headers, $content);

        $this->method = $method;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = (string)$method;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;

        return $this;
    }
}