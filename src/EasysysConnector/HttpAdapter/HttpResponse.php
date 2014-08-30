<?php

namespace EasysysConnector\HttpAdapter;

use EasysysConnector\HttpAdapter\HttpMessage;

class HttpResponse extends HttpMessage
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $reasonPhrase;

    /**
     * @param $statusCode
     * @param $reasonPhrase
     * @param array $headers
     * @param $content
     */
    public function __construct($statusCode, $reasonPhrase, array $headers, $content)
    {
        parent::__construct($headers, $content);

        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * @param $phrase
     * @return $this
     */
    public function setReasonPhrase($phrase)
    {
        $this->reasonPhrase = $phrase;

        return $this;
    }
}