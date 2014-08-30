<?php

namespace EasysysConnector\Manager\Resource\Kb;

use EasysysConnector\Manager\Resource\AbstractResourceManager;
use EasysysConnector\Model\Resource\ResourceInterface;
use EasysysConnector\Model\Resource\Kb\ResourceOfferInterface;

class ResourceOrderCommentManager extends AbstractResourceManager
{
    /**
     * @return string
     */
    public static function getResource()
    {
        return ResourceOfferInterface::RESOURCE;
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
        );
    }
}