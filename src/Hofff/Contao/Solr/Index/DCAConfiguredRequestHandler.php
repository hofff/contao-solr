<?php

namespace Hofff\Contao\Solr\Index;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 */
class DCAConfiguredRequestHandler implements RequestHandler, \ArrayAccess {

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @var string
	 */
	private $endpoint;

	/**
	 * @param array $data
	 */
	public function __construct(array $data) {
		$this->data = $data;
		$this->buildEndpoint();
	}

	/**
	 * @return void
	 */
	protected function buildEndpoint() {
		$parts = array();
		$parts[] = $this['endpoint'];
		$parts[] = $this['core'];
		$parts[] = $this['name'];
		$parts = array_map(function($part) { return trim($part, ' /'); }, $parts);
		$parts = array_filter($parts, 'strlen');
		$this->endpoint = implode('/', $parts);
	}

	/**
	 * @see \Hofff\Contao\Solr\Index\RequestHandler::getEndpoint()
	 */
	public function getEndpoint() {
		return $this->endpoint;
	}

	/**
	 * @see \Hofff\Contao\Solr\Index\RequestHandler::prepareQuery()
	 */
	public function prepareQuery(Query $query) {
		foreach(deserialize($this['params'], true) as $param) {
			if(!strlen($param['name'])) {
				continue;
			}
			$method = $param['add'] ? 'addParam' : 'setParam';
			$query->$method($param['name'], $param['value']);
		}

	}

	/**
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists($key) {
		return isset($this->data[$key]);
	}

	/**
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($key) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	/**
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet($key, $value) {
		throw new \BadMethodCallException;
	}

	/**
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset($key) {
		throw new \BadMethodCallException;
	}

}
