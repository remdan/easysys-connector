<?php

namespace EasysysConnector\Model\Resource\Contact;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceContactInterface extends ResourceInterface
{
    const RESOURCE = 'contact';

    /**
     * @return int
     */
    public function getEsUserId();

    /**
     * @return int
     */
    public function getEsOwnerId();

    /**
     * @return string
     */
    public function getEsNr();

    /**
     * @return int
     */
    public function getEsContactTypeId();
}