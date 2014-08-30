easysys-connector
=================

EasysysConnector PHP 5 library.


## Installation

### Composer

Install composer if you haven't it.

``` bash
$ curl -sS https://getcomposer.org/installer | php
```

Create a composer.json file for your project if you haven't it and put the library in it.

```{.json}
{
    "require": {
        "remdan/easysys-connector": "dev-master"
    }
}
```

Now tell composer to download the library by running the following command:

``` bash
$ php composer.phar composer install
```

or if you have already installed a composer you can update it:

``` bash
$ php composer.phar update remdan/easysys-connector
```

Composer will now fetch and install this library in the vendor directory ```vendor/remdan```

Add the autoloader:

```{.php}
require 'vendor/autoload.php';
```

### Download

If you don't use Composer in your application, just donwload the library and require the provided SplClassLoader:

```{.php}
require 'src/SplClassLoader.php';
```

## Usage

Create a EasysysConnector and add a HttpAdapter and a AuthAdapter:

```{.php}
<?php

$curlHttpAdapter = new EasysysConnector\HttpAdapter\Curl\CurlHttpAdapter();
$tokenAuthAdapter = new EasysysConnector\AuthAdapter\Token\TokenAuthAdapter();

$easysysConnector  = new EasysysConnector\EasysysConnector($curlHttpAdapter, $tokenAuthAdapter);
```

Now you have to add the resource-managers that you need:

```{.php}
<?php

$resourceContactManager = new EasysysConnector\Manager\Resource\Contact\ResourceContactManager();
...

$easysysConnector->addResourceManager($resourceContactManager);
```

### Example

```{.php}
<?php

$curlHttpAdapter = new EasysysConnector\HttpAdapter\Curl\CurlHttpAdapter();
$tokenAuthAdapter = new EasysysConnector\AuthAdapter\Token\TokenAuthAdapter();

$easysysConnector  = new EasysysConnector\EasysysConnector($curlHttpAdapter, $tokenAuthAdapter);

$resourceContactManager = new EasysysConnector\Manager\Resource\Contact\ResourceContactManager();
$easysysConnector->addResourceManager($resourceContactManager);


$data = $easysysConnector->get(ResourceContactManager::getResource())->listData(new Contact(), array('limit' => 5));

```

### Resource

Currently, there are the following resource-interfaces available:

* `ResourceContactInterface` to use [contact](https://docs.easysys.ch/ressources/contact/)
* `ResourceInvoiceInterface` to use [kb_invoice](https://docs.easysys.ch/ressources/kb_invoice/)

If you need your own just create it, but it have to implement this interface:

```{.php}
<?php

namespace EasysysConnector\Model\Resource;

interface ResourceInterface
{
    ...
}
```

### HttpAdapter

HttpAdapters are responsible to get data from remote APIs.
https://github.com/php-fig/fig-standards/blob/master/proposed/http-message.md

Currently, there are the following adapters available:

* `CurlHttpAdapter` to use [cURL](http://php.net/manual/book.curl.php)
* `GuzzleHttpAdapter` to use [Guzzle](https://github.com/guzzle/guzzle)
* `BuzzHttpAdapter` to use [Buzz](https://github.com/kriswallsmith/Buzz)

If you need your own just create it, but it have to implement this interface:

```{.php}
<?php

namespace EasysysConnector\HttpAdapter;

use EasysysConnector\HttpAdapter\HttpRequest;
use EasysysConnector\HttpAdapter\HttpResponse;

interface HttpAdapterInterface
{
    /**
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function handleRequest(HttpRequest $request);
}
```

### AuthAdapter

HttpAdapters are responsible to create the right request-object.

Currently, there are the following adapters available:
* `TokenAuthAdapter` to use [Public / Signature Key](https://docs.easysys.ch/key_version/)
* `OAuthAuthAdapter` to use [OAuth](https://docs.easysys.ch/oauth/oauth/)

If you need your own just create it, but it have to implement this interface:

```{.php}
<?php

namespace EasysysConnector\AuthAdapter;

use EasysysConnector\HttpAdapter\HttpParameterBag;

interface AuthAdapterInterface
{
    /**
     * @param HttpParameterBag $httpParameterBag
     * @return array|string[]
     */
    public function getDefaultHeaders(HttpParameterBag $httpParameterBag);

    /**
     * @param HttpParameterBag $httpParameterBag
     * @return string
     */
    public function getRequestUrl(HttpParameterBag $httpParameterBag);
}
```

### OutputHandler

OutputHandler are responsible to handle the content from the response.

Currently, there are the following adapters available:
* `ArrayOutputHandler` to use [Array](http://php.net/manual/de/language.types.array.php);
* `JsonOutputHandler` to use [Json](http://json.org);

If you need your own just create it, but it have to implement this interface:

```{.php}
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
```

### Manager

Manager are responsible to handle the request and response for a resource.

There are the following methods implemented:

```{.php}
<?php

$resourceManager->listData($resourceObject, array('limit' => 5));
$resourceManager->searchData($resourceObject, array('limit' => 5));
$resourceManager->showData($resourceObject);
$resourceManager->createData($resourceObject);
$resourceManager->editData($resourceObject);
$resourceManager->updateData($resourceObject);
$resourceManager->deleteData($resourceObject);

$resourceManager->execute($parameterBag, $outputHandler)
```

Currently, there are the following managers available:
* `ResourceContactManager` to use [contact](https://docs.easysys.ch/ressources/contact/)
* `ResourceInvoiceManager` to use [kb_invoice](https://docs.easysys.ch/ressources/kb_invoice/)

If you need your own just create it, but it have to implement this interface:

```{.php}
<?php

namespace EasysysConnector\Manager\Resource;

use EasysysConnector\AuthAdapter\AuthAdapterInterface;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;
use EasysysConnector\Model\Resource\ResourceInterface;

interface ResourceManagerInterface
{
   ...
}
```