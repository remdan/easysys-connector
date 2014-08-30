<?php

namespace EasysysConnector\Converter\Resource;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceConverterInterface
{
    /**
     * @param ResourceInterface $object
     * @return array
     */
    public function serialize(ResourceInterface $object);

    /**
     * @param $object
     * @param array $data
     * @return ResourceInterface
     */
    public function unserialize(ResourceInterface $object, array $data = array());

    /**
     * @param ResourceInterface $object
     * @return array
     */
    public function serializeSearch(ResourceInterface $object);
}