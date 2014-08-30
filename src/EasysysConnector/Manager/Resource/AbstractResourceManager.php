<?php

namespace EasysysConnector\Manager\Resource;

use EasysysConnector\Manager\Manager;
use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;
use EasysysConnector\HttpAdapter\HttpRequest;
use EasysysConnector\HttpAdapter\HttpResponse;
use EasysysConnector\Manager\Resource\ResourceManagerInterface;
use EasysysConnector\Exception\MethodNotAllowedForResourceException;
use EasysysConnector\Model\Resource\ResourceInterface;
use EasysysConnector\OutputHandler\ArrayOutputHandler;
use EasysysConnector\OutputHandler\JsonOutputHandler;
use EasysysConnector\OutputHandler\OutputHandlerInterface;
use EasysysConnector\Converter\Resource\ResourceConverterInterface;

abstract class AbstractResourceManager extends Manager implements ResourceManagerInterface
{
    /**
     * @var ResourceConverterInterface
     */
    protected $resourceConverter;

    /**
     * @param ResourceConverterInterface $resourceConverter
     * @param HttpAdapterInterface $httpAdapter
     * @param AuthAdapterInterface $authAdapter
     */
    public function __construct(
        ResourceConverterInterface $resourceConverter,
        HttpAdapterInterface $httpAdapter = null,
        AuthAdapterInterface $authAdapter = null
    )
    {
        parent::__construct($httpAdapter, $authAdapter);

        $this->resourceConverter = $resourceConverter;
    }

    /**
     * @return ResourceConverterInterface
     */
    public function getResourceConverter()
    {
        return $this->resourceConverter;
    }

    /**
     * @param ResourceConverterInterface $resourceConverter
     * @return $this
     */
    public function setResourceConverter(ResourceConverterInterface $resourceConverter)
    {
        $this->resourceConverter = $resourceConverter;

        return $this;
    }

    /**
     * @param $method
     * @return bool
     */
    public function isMethodAllowedForResource($method)
    {
        if (in_array($method, $this->getAllowedMethods())) {
            return true;
        }

        return false;
    }

    /**
     * @param $method
     * @throws MethodNotAllowedForResourceException
     */
    public function checkIsMethodAllowedForResource($method)
    {
        if (!$this->isMethodAllowedForResource($method)) {
            throw new MethodNotAllowedForResourceException();
        }
    }

    /**
     * @param $method
     * @return string
     */
    public static function getRequestUriPattern($method)
    {
        $uri = '';

        switch ($method) {
            case ResourceInterface::METHOD_LIST:
                $uri = "%s";
                break;
            case ResourceInterface::METHOD_SEARCH:
                $uri = "%s/%s";
                break;
            case ResourceInterface::METHOD_SHOW:
                $uri = "%s/%s";
                break;
            case ResourceInterface::METHOD_CREATE:
                $uri = "%s";
                break;
            case ResourceInterface::METHOD_OVERWRITE:
                $uri = "%s/%s";
                break;
            case ResourceInterface::METHOD_EDIT:
                $uri = "%s/%s";
                break;
            case ResourceInterface::METHOD_DELETE:
                $uri = "%s/%s";
                break;
        }

        return $uri;
    }

    /**
     * @param ResourceInterface $object
     * @param $method
     * @return array
     */
    public static function getResourceUriParameters(ResourceInterface $object, $method)
    {
        $resourceUriParameters = array();

        switch ($method) {
            case ResourceInterface::METHOD_LIST:
                $resourceUriParameters = array();
                $resourceUriParameters[] = $object->getEsResource();
                break;
            case ResourceInterface::METHOD_SEARCH:
                $resourceUriParameters[] = $object->getEsResource();
                $resourceUriParameters[] = ResourceInterface::METHOD_SEARCH;
                break;
            case ResourceInterface::METHOD_SHOW:
                $resourceUriParameters[] = $object->getEsResource();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_CREATE:
                $resourceUriParameters[] = $object->getEsResource();
                break;
            case ResourceInterface::METHOD_OVERWRITE:
                $resourceUriParameters[] = $object->getEsResource();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_EDIT:
                $resourceUriParameters[] = $object->getEsResource();
                $resourceUriParameters[] = $object->getEsId();
                break;
            case ResourceInterface::METHOD_DELETE:
                $resourceUriParameters[] = $object->getEsResource();
                $resourceUriParameters[] = $object->getEsId();
                break;
        }

        return $resourceUriParameters;
    }

    /**
     * @param $object
     * @param array $parameters
     * @return array|mixed
     */
    public function listData($object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_LIST);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_LIST);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_GET, ResourceInterface::METHOD_LIST, $resourceUriParameters, $parameters);
        $data = $this->execute($parameterBag, new ArrayOutputHandler());

        $entries = array();
        foreach ($data as $item) {
            $entries[] = $this->getResourceConverter()->unserialize($object, $item);
        }

        return $entries;
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function searchData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_SEARCH, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_SEARCH);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_POST, ResourceInterface::METHOD_SEARCH, $resourceUriParameters, $parameters, $this->getResourceConverter()->serializeSearch($object));

        return $this->execute($parameterBag, new ArrayOutputHandler());
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function showData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_SHOW, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_SHOW);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_GET, ResourceInterface::METHOD_SHOW, $resourceUriParameters, $parameters);
        $data = $this->execute($parameterBag, new ArrayOutputHandler());

        return $this->getResourceConverter()->unserialize($object, $data);
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function createData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_CREATE, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_CREATE);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_POST, ResourceInterface::METHOD_CREATE, $resourceUriParameters, $parameters, $this->getResourceConverter()->serialize($object));
        $data = $this->execute($parameterBag, new ArrayOutputHandler());

        return $this->getResourceConverter()->unserialize($object, $data);
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function editData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_EDIT, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_EDIT);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_POST, ResourceInterface::METHOD_EDIT, $resourceUriParameters, $parameters, $this->getResourceConverter()->serialize($object));
        $data = $this->execute($parameterBag, new ArrayOutputHandler());

        return $this->getResourceConverter()->unserialize($object, $data);
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function deleteData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_DELETE, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_DELETE);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_DELETE, ResourceInterface::METHOD_DELETE, $resourceUriParameters, $parameters);

        return $this->execute($parameterBag, new ArrayOutputHandler());
    }

    /**
     * @param ResourceInterface $object
     * @param array $parameters
     * @return HttpResponse
     */
    public function updateData(ResourceInterface $object, array $parameters = array())
    {
        $this->checkIsMethodAllowedForResource(ResourceInterface::METHOD_OVERWRITE, $object);

        $resourceUriParameters = $this->getResourceUriParameters($object, ResourceInterface::METHOD_OVERWRITE);

        $parameterBag = $this->createParameterBag(HttpAdapterInterface::HTTP_METHOD_PUT, ResourceInterface::METHOD_OVERWRITE, $resourceUriParameters, $parameters, $this->getResourceConverter()->serialize($object));
        $data = $this->execute($parameterBag, new ArrayOutputHandler());

        return $this->getResourceConverter()->unserialize($object, $data);
    }
}
