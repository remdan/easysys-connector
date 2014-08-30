<?php

namespace EasysysConnector\HttpAdapter;

class HttpMessage
{
    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $content;

    /**
     * @param array $headers
     * @param $content
     */
    public function __construct(array $headers, $content)
    {
        $this->headers = $headers;
        $this->content = $content;
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
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param $header
     * @return null
     */
    public function getHeader($header)
    {
        $headers = $this->getHeaders();
        if (array_key_exists($header, $headers)) {
            return $headers[$header];
        }

        return null;
    }

    /**
     * @param $header
     * @param $value
     * @return $this
     */
    public function setHeader($header, $value)
    {
        $headers = $this->getHeaders();

        $headers[$header] = $value;

        return $this;

    }

    /**
     * @param $header
     * @return bool
     */
    public function hasHeader($header)
    {
        if (array_key_exists($header, $this->getHeaders())) {
            return true;
        }

        return false;
    }

    /**
     * @param $header
     * @return $this
     */
    public function removeHeader($header)
    {
        $headers = $this->getHeaders();

        unset($headers[$header]);

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function setContent($content)
    {
        if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable(array($content, '__toString'))) {
            throw new \UnexpectedValueException(sprintf('The Response content must be a string or object implementing __toString(), "%s" given.', gettype($content)));
        }

        $this->content = (string)$content;

        return $this;
    }
}