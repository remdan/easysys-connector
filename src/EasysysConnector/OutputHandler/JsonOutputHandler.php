<?php

namespace EasysysConnector\OutputHandler;

use EasysysConnector\OutputHandler\OutputHandlerInterface;

class JsonOutputHandler implements OutputHandlerInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function getContent($data)
    {
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