<?php

namespace Hofff\Contao\Solr\Index;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl;
use Buzz\Message\Request;
use Hofff\Contao\Solr\Index\RequestHandler;
use Buzz\Message\RequestInterface;
use Buzz\Message\Response;

class QueryExecutor {

	private $client;

	public function __construct(ClientInterface $client = null) {
		$this->client = $client ?: new Curl;
	}

	public function execute(RequestHandler $handler, Query $query) {
		$handler->prepareQuery($query);
		$query->setParam('wt', 'json');
		$query->setParam('NOW', time() . '000');

		$params = array();
		foreach($query->getParams() as $key => $values) {
			foreach($values as $value) {
				$params[] = urlencode($key) . '=' . urlencode($value);
			}
		}

		$resource = $handler->getEndpoint();
		$params && $resource .= '?' . implode('&', $params);

		$request = new Request;
		$request->setResource($resource);

		if($query->hasContent()) {
			$request->setMethod(RequestInterface::METHOD_POST);
			$request->setContent($query->getContent());
			$request->addHeader('Content-Type: ' . $query->getContentType());
		}

		$response = new Response;

		$this->client->send($request, $response);

		if(!$response->isOk()) {
			throw new \Exception($response->getReasonPhrase(), $response->getStatusCode());
		}

		return $response->getContent();
	}

}
