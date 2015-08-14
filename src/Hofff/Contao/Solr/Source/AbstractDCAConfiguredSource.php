<?php

namespace Hofff\Contao\Solr\Source;

abstract class AbstractDCAConfiguredSource implements Source, \ArrayAccess {

	private $data;

	protected function __construct(array $data) {
		$this->data = $data;
	}

	public function getName() {
		return $this['name'];
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
