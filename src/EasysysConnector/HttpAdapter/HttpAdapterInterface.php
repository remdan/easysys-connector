<?php

namespace EasysysConnector\HttpAdapter;

use EasysysConnector\HttpAdapter\HttpRequest;
use EasysysConnector\HttpAdapter\HttpResponse;

interface HttpAdapterInterface
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_PUT = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';

    const HTTP_HEADER_CONTENT_TYPE = 'Content-Type';

    /**
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function handleRequest(HttpRequest $request);
}