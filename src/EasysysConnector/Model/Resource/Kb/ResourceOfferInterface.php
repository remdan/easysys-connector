<?php

namespace EasysysConnector\Model\Resource\Kb;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceOfferInterface extends ResourceInterface
{
    const RESOURCE = 'kb_offer';

    /**
     * @return int
     */
    public function getEsUserId();

    /**
     * @return int
     */
    public function getEsContactId();
}