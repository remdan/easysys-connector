<?php

namespace EasysysConnector\Manager\Resource;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\Manager\ManagerInterface;
use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceManagerInterface extends ManagerInterface
{
    /**
     * @return string
     */
    public static function getResource();

    /**
     * @return array|string[]
     */
    public static function getAllowedMethods();

    /**
     * @param ResourceInterface $object
     * @param $method
     * @return string
     */
    public static function getResourceUriParameters(ResourceInterface $object, $method);

    /**
     * @param $method
     * @return string
     */
    public static function getRequestUriPattern($method);


    /**
     * @param $object
     * @param array $parameters
     * @return mixed
     */
    public function listData($object, array $parameters = array());
}