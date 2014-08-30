<?php

namespace EasysysConnector\Model\Resource\Kb;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceInvoiceInterface extends ResourceInterface
{
    const RESOURCE = 'kb_invoice';

    /**
     * @return int
     */
    public function getEsUserId();

    /**
     * @return int
     */
    public function getEsContactId();
}