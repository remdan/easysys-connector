<?php

namespace EasysysConnector\HttpAdapter\Curl;

use EasysysConnector\Exception\ExtensionNotLoadedException;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use \Exception;
use EasysysConnector\HttpAdapter\HttpResponse;
use EasysysConnector\HttpAdapter\HttpRequest;
use Symfony\Component\HttpFoundation\Response;

class CurlHttpAdapter implements HttpAdapterInterface
{
    /**
     *
     */
    public function __construct()
    {
        $this->checkIsCurlEnabled();
    }

    /**
     * @param HttpRequest $request
     * @return mixed
     */
    public function handleRequest(HttpRequest $request)
    {
        $content = $request->getContent();
        if ($request->hasHeader(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE) && $request->getHeader(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE) == 'application/json') {
            $content = http_build_query(json_decode($content));
        }

        $curl = $this->createCurlCall($request->getUrl(), $request->getHeaders(), $content, $request->getMethod());

        return $this->execute($curl);
    }

    /**
     * @param $curl
     * @return HttpResponse
     */
    public function execute($curl)
    {
        $data = curl_exec($curl);

        $curlInfo = curl_getinfo($curl);

        curl_close($curl);

        $response = new HttpResponse($curlInfo['http_code'], '', array(HttpAdapterInterface::HTTP_HEADER_CONTENT_TYPE => $curlInfo['content_type']), $data);

        return $response;
    }

    /**
     * @param $url
     * @param array $headers
     * @param string $content
     * @param string $method
     * @return resource
     */
    public function createCurlCall($url, $headers = array(), $content = '', $method = 'GET')
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HEADER, false);

        if ($headers) {
            $httpheader = array();
            foreach ($headers as $key => $value) {
                $httpheader[] = $key . ': ' . $value;
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
        }

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        }

        //$curl = $this->enableCurlOptionProxy($curl);

        return $curl;
    }

    /**
     * @return bool
     * @throws ExtensionNotLoadedException
     */
    private function checkIsCurlEnabled()
    {
        if (!function_exists('curl_version')) {
            throw new ExtensionNotLoadedException('cURL has to be installed or enabled.');
        }

        return true;
    }

    /**
     * enable those two lines in order to debug api calls with aproxy like charles
     */
    public function enableCurlOptionProxy($curl)
    {
        curl_setopt($curl, CURLOPT_PROXY, "127.0.0.1");
        curl_setopt($curl, CURLOPT_PROXYPORT, 8890);

        return $curl;
    }
}