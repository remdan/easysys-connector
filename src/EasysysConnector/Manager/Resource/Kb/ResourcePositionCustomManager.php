<?php

namespace EasysysConnector\Manager\Resource\Kb;

use EasysysConnector\Manager\Resource\AbstractResourceManager;
use EasysysConnector\Model\Resource\ResourceInterface;
use EasysysConnector\Model\Resource\Kb\ResourcePositionCustomInterface;

class ResourcePositionCustomManager extends AbstractResourceManager
{
    /**
     * @return string
     */
    public static function getResource()
    {
        return ResourcePositionCustomInterface::RESOURCE;
    }

    /**
     * @return array|string[]
     */
    public static function getAllowedMethods()
    {
        return array(
            ResourceInterface::METHOD_LIST,
            ResourceInterface::METHOD_SEARCH,
            ResourceInterface::METHOD_SHOW,
            ResourceInterface::METHOD_CREATE,
            ResourceInterface::METHOD_OVERWRITE,
            ResourceInterface::METHOD_EDIT,
            ResourceInterface::METHOD_DELETE
        );
    }

    /**
     * @param $method
     * @return string
     */
    public static function getRequestUriPattern($method)
    {
        $uri = '';

        switch ($method) {
            case ResourceInterface::METHOD_LIST:
                $uri = "%s/%s/kb_position_custom";
                break;
            case ResourceInterface::METHOD_SEARCH:
                $uri = "%s/%s/kb_position_custom/search";
                break;
            case ResourceInterface::METHOD_SHOW:
                $uri = "%s/%s/kb_position_custom/%s";
                break;
            case ResourceInterface::METHOD_CREATE:
                $uri = "%s/%s/kb_position_custom";
                break;
            case ResourceInterface::METHOD_OVERWRITE:
                $uri = "%s/%s/kb_position_custom/%s";
                break;
            case ResourceInterface::METHOD_EDIT:
                $uri = "%s/%s/kb_position_custom/%s";
                break;
            case ResourceInterface::METHOD_DELETE:
                $uri = "%s/%s/kb_position_custom/%s";
                break;
        }

        return $uri;
    }

    /**
     * @param ResourceInterface $object
     * @param $method
     * @return array
     */
    public static function getResourceUriParameters(ResourceInterface $object, $method)
    {
        $resourceUriParameters = array();

        switch ($method) {
            case ResourceInterface::METHOD_LIST:
                $resourceUriParameters = array();
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                break;
            case ResourceInterface::METHOD_SEARCH:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                $resourceUriParameters[] = ResourceInterface::METHOD_SEARCH;
                break;
            case ResourceInterface::METHOD_SHOW:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_CREATE:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                break;
            case ResourceInterface::METHOD_OVERWRITE:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_EDIT:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_DELETE:
                $resourceUriParameters[] = $object->getResourceParent()->getEsResource();
                $resourceUriParameters[] = $object->getResourceParent()->getEsId();
                $resourceUriParameters[] = $object->getEsId();
                break;
        }

        return $resourceUriParameters;
    }
}