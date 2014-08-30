<?php

namespace EasysysConnector\Model\Resource\Kb;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceOrderInterface extends ResourceInterface
{
    const RESOURCE = 'kb_order';

    /**
     * @return int
     */
    public function getEsUserId();

    /**
     * @return int
     */
    public function getEsContactId();
}