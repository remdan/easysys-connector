<?php

namespace EasysysConnector\HttpAdapter\Guzzle;

use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\HttpAdapter\HttpResponse;
use EasysysConnector\HttpAdapter\HttpRequest;
use Guzzle\Service\ClientInterface;
use Guzzle\Service\Client;

class GuzzleHttpAdapter implements HttpAdapterInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = null === $client ? new Client() : $client;
    }

    /**
     * @return Client|ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function handleRequest(HttpRequest $request)
    {
        //TODO: Guzzle request
        $guzzleRequest = $this->client->createRequest($request->getMethod(), $request->getUrl(), $request->getHeaders());

        $guzzleRequest->getCurlOptions()->remove(CURLOPT_SSL_VERIFYPEER);
        $guzzleRequest->getCurlOptions()->remove(CURLOPT_CAINFO);

        $guzzleRequest->getCurlOptions()->add(CURLOPT_SSL_VERIFYPEER, 0);
        $guzzleRequest->getCurlOptions()->add(CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        $guzzleRequest->getCurlOptions()->add(CURLOPT_RETURNTRANSFER, true);
        $guzzleRequest->getCurlOptions()->add(CURLOPT_VERBOSE, 0);
        $guzzleRequest->getCurlOptions()->add(CURLOPT_HEADER, false);
        $guzzleRequest->getCurlOptions()->add(CURLOPT_TIMEOUT, 10);


        //$guzzleRequest = $this->enableCurlOptionProxy($guzzleRequest);

        //TODO: Guzzle response
        $guzzleResponse = $this->client->send($guzzleRequest);

        $response = new HttpResponse($guzzleResponse->getInfo('http_code'), '', array(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE => $guzzleResponse->getInfo('content_type')), $guzzleResponse->getBody(true));

        return $response;
    }

    /**
     * enable those two lines in order to debug api calls with aproxy like charles
     */
    public function enableCurlOptionProxy($guzzleRequest)
    {
        $guzzleRequest->getCurlOptions()->add(CURLOPT_PROXY, "127.0.0.1");
        $guzzleRequest->getCurlOptions()->add(CURLOPT_PROXYPORT, 8890);

        return $guzzleRequest;
    }
}