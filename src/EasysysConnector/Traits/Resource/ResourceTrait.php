<?php

namespace EasysysConnector\Traits\Resource;
use EasysysConnector\Model\Resource\ResourceInterface;

trait ResourceTrait
{
    /**
     * @var int
     */
    protected $esId;

    /**
     * @return int
     */
    public function getEsId()
    {
        return $this->esId;
    }

    /**
     * @param null $id
     * @return $this
     */
    public function setEsId($id = null)
    {
        $this->esId = $id;

        return $this;
    }

    /**
     * @return ResourceInterface
     */
    public function getResourceParent()
    {
        return null;
    }
}