<?php

namespace EasysysConnector;

use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;
use EasysysConnector\Manager\Manager;
use EasysysConnector\Manager\Resource\ResourceManager;
use EasysysConnector\Manager\Resource\ResourceManagerInterface;
use EasysysConnector\OutputHandler\OutputHandlerInterface;

class EasysysConnector
{
    /**
     * @var HttpAdapterInterface
     */
    protected $httpAdapter;

    /**
     * @var AuthAdapterInterface
     */
    protected $authAdapter;

    /**
     * @var array|ResourceManagerInterface[]
     */
    protected $resourceManagers = array();

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @param AuthAdapterInterface $authAdapter
     * @param array $resourceManagers
     */
    public function __construct(
        HttpAdapterInterface $httpAdapter = null,
        AuthAdapterInterface $authAdapter = null,
        array $resourceManagers
    )
    {
        $this->httpAdapter = $httpAdapter;
        $this->authAdapter = $authAdapter;

        $this->initResourceManagers($resourceManagers);
    }

    /**
     * @return HttpAdapterInterface
     * @throws \Exception
     */
    public function getHttpAdapter()
    {
        if (is_null($this->httpAdapter)) {
            throw new \Exception('Please define a httpAdapter based on the HttpAdapterInterface!');
        }

        return $this->httpAdapter;
    }

    /**
     * @param HttpAdapterInterface $httpAdapter
     * @return $this
     */
    public function setHttpAdapter(HttpAdapterInterface $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;

        return $this;
    }

    /**
     * @return AuthAdapterInterface
     * @throws \Exception
     */
    public function getAuthAdapter()
    {
        if (is_null($this->authAdapter)) {
            throw new \Exception('Please define a authAdapter based on the AuthAdapterInterface!');
        }

        return $this->authAdapter;
    }

    /**
     * @param AuthAdapterInterface $authAdapter
     * @return $this
     */
    public function setAuthAdapter(AuthAdapterInterface $authAdapter)
    {
        $this->authAdapter = $authAdapter;

        return $this;
    }

    /**
     * @param array $resourceManagers
     * @throws \InvalidArgumentException
     */
    protected function initResourceManagers(array $resourceManagers)
    {
        $this->resourceManagers = array();
        foreach ($resourceManagers as $resourceManager) {
            if (!$resourceManager instanceof ResourceManagerInterface) {
                throw new \InvalidArgumentException();
            }

            $this->addResourceManager($resourceManager);
        }
    }

    /**
     * @return array|ResourceManagerInterface[]
     */
    public function getResourceManagers()
    {
        return $this->resourceManagers;
    }

    /**
     * @param $resource
     * @return ResourceManagerInterface
     * @throws \InvalidArgumentException
     */
    public function getResourceManager($resource)
    {
        if (!isset($this->resourceManagers[$resource])) {
            throw new \InvalidArgumentException("Invalid resource manager name given or manager is not registered");
        }

        return $this->resourceManagers[$resource];
    }

    /**
     * @param ResourceManagerInterface $resourceManager
     */
    public function addResourceManager(ResourceManagerInterface $resourceManager)
    {
        if (!in_array($resourceManager, $this->getResourceManagers())) {
            $resourceManager->setHttpAdapter($this->getHttpAdapter());
            $resourceManager->setAuthAdapter($this->getAuthAdapter());
            $this->resourceManagers[$resourceManager->getResource()] = $resourceManager;
        }
    }

    /**
     * @return Manager
     * @throws \Exception
     */
    public function getManager()
    {
        $manager = new Manager($this->getHttpAdapter(), $this->getAuthAdapter());

        return $manager;
    }

    /**
     * @param HttpParameterBag $parameterBag
     * @param OutputHandlerInterface $outputHandler
     * @return HttpAdapter\HttpResponse
     * @throws \Exception
     */
    public function execute(HttpParameterBag $parameterBag, OutputHandlerInterface $outputHandler = null)
    {
        return $this->getManager()->execute($parameterBag, $outputHandler);
    }

    /**
     * @param $resource
     * @return ResourceManagerInterface
     */
    public function get($resource)
    {
        return $this->getResourceManager($resource);
    }
}