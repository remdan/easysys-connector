<?php

namespace EasysysConnector\Model\Resource\Kb;

use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceOrderCommentInterface extends ResourceInterface
{
    const RESOURCE = 'kb_order';

    /**
     * @return int
     */
    public function getEsUserId();

    /**
     * @return string
     */
    public function getEsUserName();

    /**
     * @return int
     */
    public function getEsText();
}