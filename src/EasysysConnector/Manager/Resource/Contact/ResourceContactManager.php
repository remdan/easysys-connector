<?php

namespace EasysysConnector\Manager\Resource\Contact;

use EasysysConnector\Manager\Resource\AbstractResourceManager;
use EasysysConnector\Model\Resource\ResourceInterface;
use EasysysConnector\Model\Resource\Contact\ResourceContactInterface;

class ResourceContactManager extends AbstractResourceManager
{
    /**
     * @return string
     */
    public static function getResource()
    {
        return ResourceContactInterface::RESOURCE;
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
}