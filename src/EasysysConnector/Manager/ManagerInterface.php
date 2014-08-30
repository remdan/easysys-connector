<?php

namespace EasysysConnector\Manager;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;

interface ManagerInterface
{
    /**
     * @return HttpAdapterInterface
     */
    public function getHttpAdapter();

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @return mixed
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter);

    /**
     * @return AuthAdapterInterface
     */
    public function getAuthAdapter();

    /**
     * @param AuthAdapterInterface $authAdapter
     * @return mixed
     */
    public function setAuthAdapter(AuthAdapterInterface $authAdapter);

    /**
     * @param string $method
     * @return string
     */
    public static function getRequestUriPattern($method);
}