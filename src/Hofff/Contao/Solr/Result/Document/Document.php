<?php

namespace Hofff\Contao\Solr\Result\Document;

class Document implements \ArrayAccess {

	const URL_AUTO = 0;
	const URL_ABSOLUTE = 1;
	const URL_RELATIVE = 2;

	private $data;

	public function __construct(array $data = null) {
		$this->data = (array) $data;
	}

	public function getData() {
		return $this->data;
	}

	public function setData(array $data) {
		$this->data = $data;
	}

	public function getTitle($index = 0) {
		return $this->data['title'][$index];
	}

	public function getTitles($glue = null) {
		if(is_string($glue)) {
			return implode($glue, array_filter($this->data['title'], 'strlen'));
		} else {
			return $this->data['title'];
		}
	}

	public function getURL($format = self::URL_AUTO) {
		if($format == self::URL_RELATIVE) {
			return $this->data['m_request_s'];
		}

		if($format != self::URL_ABSOLUTE && \Environment::getInstance()->base == $this->data['m_base_s']) {
			return $this->data['m_request_s'];
		}

		return $this->data['m_base_s'] . $this->data['m_request_s'];
	}

	public function getType() {
		return $this->data['m_doctype_s'];
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
		return $this->data[$key];
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
