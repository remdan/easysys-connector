<?php

namespace EasysysConnector\OutputHandler;

interface OutputHandlerInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function getContent($data);
}