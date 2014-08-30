<?php

namespace EasysysConnector\AuthAdapter\Token;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;

class TokenAuthAdapter implements AuthAdapterInterface
{
    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var string
     */
    protected $signatureKey;

    /**
     * @param null $company
     * @param null $userId
     * @param null $publicKey
     * @param null $signatureKey
     */
    public function __construct($company = null, $userId = null, $publicKey = null, $signatureKey = null)
    {
        $this->company = $company;
        $this->userId = $userId;
        $this->publicKey = $publicKey;
        $this->signatureKey = $signatureKey;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null $company
     * @return $this
     */
    public function setCompany($company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null $userId
     * @return $this
     */
    public function setUserId($userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param null $publicKey
     * @return $this
     */
    public function setPublicKey($publicKey = null)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getSignatureKey()
    {
        return $this->signatureKey;
    }

    /**
     * @param null $signatureKey
     * @return $this
     */
    public function setSignatureKey($signatureKey = null)
    {
        $this->signatureKey = $signatureKey;

        return $this;
    }

    /**
     * @param HttpParameterBag $parameterBag
     * @return array
     */
    public function getDefaultHeaders(HttpParameterBag $parameterBag)
    {
        $parametersPost = $parameterBag->getParameterPost();

        if (!empty($parametersPost)) {
            $parametersPost = json_encode($parameterBag->getParameterPost());
        } else {
            $parametersPost = '';
        }

        $signatureKey = strtolower($parameterBag->getMethod()) . $this->getRequestUrl($parameterBag) . $parametersPost . $this->getSignatureKey();

        $httpheaders = array(
            'Accept' => $parameterBag->getAccept(),
            'Signature' => md5($signatureKey)
        );

        return $httpheaders;
    }

    /**
     * @param HttpParameterBag $httpParameterBag
     * @return string
     */
    public function getRequestUrl(HttpParameterBag $httpParameterBag)
    {
        $parameters = '';
        $parametersGet = $httpParameterBag->getParameterGet();
        if (!empty($parametersGet)) {
            $parameters = (string)'?' . http_build_query($httpParameterBag->getParameterGet());
        }

        return (string)$httpParameterBag->getBaseUrl() . DIRECTORY_SEPARATOR . $this->getRequestUri($httpParameterBag->getUri()) . '' . $parameters;
    }

    /**
     * @param string $uri
     * @return string
     */
    public function getRequestUri($uri = '')
    {
        return (string)sprintf('%s/%s/%s/%s', $this->getCompany(), $this->getUserId(), $this->getPublicKey(), $uri);
    }
}