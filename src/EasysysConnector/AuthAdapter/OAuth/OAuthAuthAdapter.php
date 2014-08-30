<?php

namespace EasysysConnector\AuthAdapter\OAuth;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;

class OAuthAuthAdapter implements AuthAdapterInterface
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $org;

    /**
     * @param $token
     * @param $org
     */
    public function __construct($token, $org)
    {
        $this->token = $token;
        $this->org = $org;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param null $token
     * @return $this
     */
    public function setToken($token = null)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * @param null $org
     * @return $this
     */
    public function setOrg($org = null)
    {
        $this->org = $org;

        return $this;
    }

    /**
     * @param HttpParameterBag $parameterBag
     * @return array
     */
    public function getDefaultHeaders(HttpParameterBag $parameterBag)
    {
        $httpheaders = array(
            'Accept' => $parameterBag->getAccept()
        );

        $httpheaders['Authorization'] = 'Bearer ' . $this->getToken();

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

        return (string)$httpParameterBag->getBaseUrl() . '' . $this->getRequestUri($httpParameterBag->getResource()) . '' . $parameters;
    }

    /**
     * @param string $ressource
     * @return string
     * @throws \Exception
     */
    public function getRequestUri($ressource = '')
    {
        return (string)sprintf('/%s/%s', $this->getOrg(), $ressource);
    }
}