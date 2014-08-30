<?php

namespace EasysysConnector\Model\Resource;

interface ResourceInterface
{
    const METHOD_LIST = 'list';
    const METHOD_SEARCH = 'search';
    const METHOD_SHOW = 'show';
    const METHOD_CREATE = 'create';
    const METHOD_OVERWRITE = 'overwrite';
    const METHOD_EDIT = 'edit';
    const METHOD_DELETE = 'delete';

    /**
     * @return string
     */
    public static function getEsResource();

    /**
     * @return int
     */
    public function getEsId();

    /**
     * @return mixed
     */
    public function setEsId();

    /**
     * @return ResourceInterface|Null
     */
    public function getResourceParent();
}