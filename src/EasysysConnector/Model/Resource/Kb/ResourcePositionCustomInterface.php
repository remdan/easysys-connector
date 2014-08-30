<?php

namespace EasysysConnector\Model\Resource\Kb;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourcePositionCustomInterface extends ResourceInterface
{
    const RESOURCE = 'kb_position_custom';

    /**
     * @return float
     */
    public function getEsAmount();

    /**
     * @return float
     */
    public function getEsUnitPrice();

    /**
     * @return int
     */
    public function getEsTaxId();
}