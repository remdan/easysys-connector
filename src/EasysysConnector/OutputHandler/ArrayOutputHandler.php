<?php

namespace EasysysConnector\OutputHandler;

use EasysysConnector\OutputHandler\OutputHandlerInterface;

class ArrayOutputHandler implements OutputHandlerInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function getContent($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if ($this->isJson($data)) {
            return json_decode($data, true);
        }

        return $data;
    }

    /**
     * @param $data
     * @return bool
     */
    protected function isJson($data)
    {
        return json_decode($data) != null;
    }
}