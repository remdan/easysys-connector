<?php

namespace EasysysConnector\Traits\Resource\Kb;

use EasysysConnector\Model\Resource\Kb\ResourceInvoiceInterface;

trait ResourceInvoiceTrait
{
    /**
     * @var int
     */
    protected $esUserId;

    /**
     * @var int
     */
    protected $esContactId;

    /**
     * @return string
     */
    public static function getEsResource()
    {
        return ResourceInvoiceInterface::RESOURCE;
    }

    /**
     * @return int
     */
    public function getEsUserId()
    {
        return $this->esUserId;
    }

    /**
     * @param null $userId
     * @return $this
     */
    public function setEsUserId($userId = null)
    {
        $this->esUserId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsContactId()
    {
        return $this->esContactId;
    }

    /**
     * @param null $esContactId
     * @return $this
     */
    public function setEsContactId($esContactId = null)
    {
        $this->esContactId = $esContactId;

        return $this;
    }
}