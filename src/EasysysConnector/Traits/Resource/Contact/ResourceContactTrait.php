<?php

namespace EasysysConnector\Traits\Resource\Contact;

use EasysysConnector\Model\Resource\Contact\ResourceContactInterface;

trait ResourceContactTrait
{
    /**
     * @var int
     */
    protected $esUserId;

    /**
     * @var int
     */
    protected $esOwnerId;

    /**
     * @var string
     */
    protected $esNr;

    /**
     * @var int
     */
    protected $esContactTypeId;

    /**
     * @return string
     */
    public static function getEsResource()
    {
        return ResourceContactInterface::RESOURCE;
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
    public function getEsOwnerId()
    {
        return $this->esOwnerId;
    }

    /**
     * @param null $ownerId
     * @return $this
     */
    public function setEsOwnerId($ownerId = null)
    {
        $this->esOwnerId = $ownerId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsContactTypeId()
    {
        return $this->esContactTypeId;
    }

    /**
     * @param null $contactTypeId
     * @return $this
     */
    public function setEsContactTypeId($contactTypeId = null)
    {
        $this->esContactTypeId = $contactTypeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEsNr()
    {
        return $this->esNr;
    }

    /**
     * @param null $nr
     * @return $this
     */
    public function setEsNr($nr = null)
    {
        $this->esNr = $nr;

        return $this;
    }
}