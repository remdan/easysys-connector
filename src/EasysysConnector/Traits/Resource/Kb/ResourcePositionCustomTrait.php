<?php

namespace EasysysConnector\Traits\Resource\Kb;

use EasysysConnector\Model\Resource\Kb\ResourcePositionCustomInterface;

trait ResourcePositionCustomTrait
{
    /**
     * @var float
     */
    protected $esAmount;

    /**
     * @var float
     */
    protected $esUnitPrice;

    /**
     * @var int
     */
    protected $esTaxId;


    /**
     * @return string
     */
    public static function getEsResource()
    {
        return ResourcePositionCustomInterface::RESOURCE;
    }

    /**
     * @return int
     */
    public function getEsAmount()
    {
        return $this->esAmount;
    }

    /**
     * @param null $amount
     * @return $this
     */
    public function setEsAmount($amount = null)
    {
        $this->esAmount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsUnitPrice()
    {
        return $this->esUnitPrice;
    }

    /**
     * @param null $unitPrice
     * @return $this
     */
    public function setEsUnitPrice($unitPrice = null)
    {
        $this->esUnitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsTaxId()
    {
        return $this->esTaxId;
    }

    /**
     * @param null $taxId
     * @return $this
     */
    public function setEsTaxId($taxId = null)
    {
        $this->esTaxId = $taxId;

        return $this;
    }
}