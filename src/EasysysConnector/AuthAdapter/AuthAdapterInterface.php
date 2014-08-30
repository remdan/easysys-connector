<?php

namespace EasysysConnector\AuthAdapter;

use EasysysConnector\HttpAdapter\HttpParameterBag;

interface AuthAdapterInterface
{
    /**
     * @param HttpParameterBag $httpParameterBag
     * @return array|string[]
     */
    public function getDefaultHeaders(HttpParameterBag $httpParameterBag);

    /**
     * @param HttpParameterBag $httpParameterBag
     * @return string
     */
    public function getRequestUrl(HttpParameterBag $httpParameterBag);
}